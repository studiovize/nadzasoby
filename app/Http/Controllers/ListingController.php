<?php

namespace App\Http\Controllers;

use App\Events\CreditSpent;
use App\Events\ListingApproved;
use App\Events\ListingCreated;
use App\Events\ListingRejected;
use App\Events\ListingUpdated;
use App\Events\Searched;
use App\Models\Area;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Listing;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class ListingController extends Controller
{
    private function generateTitle(Request $request, $count): string
    {
        if (!in_array_any(['s', 'area', 'category', 'date'], array_keys(array_filter($request->all())))) {
            $title = $request->get('type') === 'buy' ? 'Všechny poptávky' : 'Všechny nabídky';
        } else {
            $title = $request->get('type') === 'buy' ? 'Poptávky' : 'Nabídky';
        }

        if ($request->filled('s')) {
            $title .= " obsahující \"<b>{$request->get('s')}</b>\"";
        }

        if ($request->filled('area')) {
            $area = Area::where('id', $request->get('area'))->firstOrFail();
            $title .= " v lokalitě <b>$area->name</b>";
        }

        if ($request->filled('category')) {
            $category = Category::where('id', $request->get('category'))->firstOrFail();
            $title .= " v kategorii <b>$category->name</b>";
        }

        $title .= " ($count)";

        return $title;
    }

    public function index(Request $request)
    {
        $listings_limit = 6;

        $categories = getCachedCategories();

        $listings = Listing::where([
            ['is_active', '=', true],
            ['is_removed', '=', false],
            ['is_approved', '=', true],
        ])
            ->with('category')
            ->orderBy('is_highlighted', 'desc')
            ->latest();

        $listings_count = $listings->count();

        $listings = $listings->limit($listings_limit)->get();

        return view('listings.index', compact('listings', 'listings_count', 'categories'));
    }

    public function search(Request $request)
    {
        $search_data = [
            'user_id' => Auth::id()
        ];

        $pagination = $request->has('pagination') ? (int)$request->get('pagination') : 6;
        // start querying
        $listings = Listing::where([
            ['is_active', '=', true],
            ['is_removed', '=', false],
            ['is_approved', '=', true]
        ])
            ->with('category')
            ->orderBy('is_highlighted', 'desc')
            ->latest();

        if ($request->has('category') && !is_null($request->get('category'))) {
            $search_data['category_id'] = $request->get('category');

            $listings = $listings->where('category_id', '=', $request->get('category'));

//            $listings = $listings->whereHas('category', function ($query) use ($request) {
//                return $query->where('id', '=', $request->get('category'))
//                    ->orWhere('category_id', '=', $request->get('category'));
//            });
        }

        if ($request->has('type') && !is_null($request->get('type'))) {
            $listings = $listings->where('type', $request->get('type'));
        }

        if ($request->has('date') && !is_null($request->get('date'))) {
            switch ($request->get('date')) {
                case 'day':
                    $days = 1;
                    break;
                case 'week':
                    $days = 7;
                    break;
                case 'month':
                    $days = 30;
                    break;
                default:
                    $days = 999;
                    break;
            }

            $listings = $listings->where('created_at', '>=', Carbon::now()->subDays($days)->toDateTimeString());
        }

        if ($request->has('area') && !is_null($request->get('area'))) {
            $area = Area::where('id', $request->get('area'))->with('subareas')->first();

            if ($area) {
                $search_data['area_id'] = $request->get('area');

                $area_with_subareas = array_merge([$area->id], $area->subareas->pluck('id')->toArray());
                $listings = $listings->whereIn('area_id', $area_with_subareas);
            }
        }

        if ($request->has('condition') && !is_null($request->get('condition'))) {
            $condition = Condition::where('id', $request->get('condition'))->first();

            if ($condition) {
                $listings = $listings->where('condition_id', $condition->id);
            }
        }

        if ($request->has('s') && !is_null($request->get('s'))) {
            $query = strtolower($request->get('s'));
            $listings = $listings->where(function ($q) use ($query) {
                return $q->where('title', 'like', "%$query%")
                    ->orWhere('content', 'like', "%$query%");
            });
        }

        $title = $this->generateTitle($request, $listings->count());

        $listings = $listings->paginate($pagination)->withQueryString();


        // get all categories names + slugs + count
        $categories = Cache::remember('categories', now()->addDay(), function () {
            return Category::orderBy('name')->get();
        });

        // get all the areas
        $areas = Cache::remember('areas', now()->addDay(), function () {
            return Area::where('area_id', NULL)->with('subareas')->get();
        });

        // get all conditions
        $conditions = Cache::remember('conditions', now()->addDay(), function () {
            return Condition::all();
        });

        event(new Searched($search_data));

        return view('listings.search', compact('title', 'listings', 'categories', 'areas', 'conditions'));
    }

    public function show(Listing $listing, Request $request)
    {
        if (!$listing->is_approved && !Auth::user()->hasRole('admin')) {
            abort(404);
        }
        if (!$listing->is_active) {
            if (!Auth::check()) {
                abort(404);
            }

            if (Auth::id() !== $listing->user_id && !Auth::user()->hasRole('admin')) {
                abort(404);
            }
        }

        $breadcrumbs = generateBreadcrumbs($listing);

        return view('listings.show', compact('listing', 'breadcrumbs'));
    }

    public function confirmUnlock(Request $request, Listing $listing)
    {
        return view('listings.confirm-unlock', compact('listing'));
    }

    public function unlock(Request $request, Listing $listing)
    {
        $user = Auth::user();

        DB::table('listing_user')->insert([
            'listing_id' => $listing->id,
            'user_id' => $user->id,
            'created_at' => now()
        ]);

        $user->credit->decrement('amount');

        event(new CreditSpent($user->credit, 1, 'unlock', $listing));

        return redirect(route('listings.show', ['listing' => $listing]));
    }

    public function apply(Request $request, Listing $listing)
    {
        return view('listings.apply')->with(compact('listing'));
//        $listing->views()->create([
//            'user_agent' => $request->userAgent(),
//            'ip' => $request->ip()
//        ]);
    }

    public function create(Request $request)
    {
        $categories = getCachedCategories();
        $conditions = Condition::all();
        $units = Unit::all();
        $areas = Area::where('area_id', NULL)->with('subareas')->get();

        return view('listings.create')->with([
            'categories' => $categories,
            'conditions' => $conditions,
            'units' => $units,
            'areas' => $areas,
        ]);
    }

    public function store(Request $request)
    {
//        $validationArray = [
//            'title' => 'required',
//            'type' => 'required',
////            'location' => 'required',
//            'phone' => 'required',
////            'image' => 'file|max:2048',
//            'content' => 'required',
//        ];
//
//        $request->validate($validationArray);

        $user = Auth::user();

        $uploads_dir = public_path() . '/uploads/' . $user->id;
        File::isDirectory($uploads_dir) or File::makeDirectory($uploads_dir, 0777, true, true);

        $images = [];
        $thumbnail = '';

        if ($request->filled('files')) {
            foreach ($request->get('files') as $key => $file) {
                $file_name = "product-" . time() . '-' . Str::random(16) . ".jpg";
                $path = $uploads_dir . '/' . $file_name;
                Image::make(file_get_contents($file))->save($path);

                $images[] = $user->id . '/' . $file_name;

                if ($key === 0) {
                    $thumbnail_path = $uploads_dir . '/t_' . $file_name;
                    Image::make(file_get_contents($file))->resize(500, 500, function ($const) {
                        $const->aspectRatio();
                    })->save($thumbnail_path);

                    $thumbnail = $user->id . '/t_' . $file_name;
                }
            }
        }

        if ($request->type === 'buy') {
            if ($user->credit_amount < env('PRICE_BUY_TYPE')) {
                return response()->json(['status' => 403, 'error' => 'Not enough credit.']);
            }
        }

        $is_negotiable = $request->is_negotiable === '1';
        $is_price_in_content = $request->is_price_in_content === '1';
        $tax_included = $request->tax_included === '1';
        $price = $request->price;

        if ($is_negotiable || $is_price_in_content) {
            $price = null;
        }

        try {
            $listing = Listing::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . rand(1111, 9999),
                'user_id' => $user->id,
                'category_id' => $request->category,
                'type' => $request->type,
                'phone' => $request->phone,
                'price' => $price,
                'tax_included' => $tax_included,
                'is_negotiable' => $is_negotiable,
                'is_price_in_content' => $is_price_in_content,
                'thumbnail' => $thumbnail,
                'images' => $images,
                'content' => nl2br(strip_tags(rtrim($request->get('content')))),
                'is_active' => true,
                'is_approved' => false,
                'condition_id' => $request->condition,
                'unit_id' => $request->unit,
                'area_id' => $request->area,
                'amount' => $request->amount,
                'is_highlighted' => $request->filled('is_highlighted'),
            ]);

            if ($request->type === 'buy') {
                $user->credit->decrement('amount', env('PRICE_BUY_TYPE'));
            }

            event(new ListingCreated($listing));

//            return redirect()->route('listings.show', ['listing' => $listing->slug]);
            return response()->json(['status' => 200, 'redirect_to' => route('listings.highlight-confirm', $listing->slug)]);


        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    private function modifyListingForEdit($listing)
    {
        $newListing = new Listing;

        $allowed = [
            'category_id',
            'title',
            'price',
            'content',
            'type',
            'condition_id',
            'unit_id',
            'area_id',
            'is_negotiable',
            'amount',
            'phone',
            'tax_included',
            'is_price_in_content'
        ];

        foreach ($listing->getAttributes() as $key => $value) {
            if (in_array($key, $allowed)) {

                switch ($key) {
                    case 'category_id':
                        $key = 'category';
                        $value = Category::where('id', $value)->get('id')->first()->id;
                        break;
                    case 'condition_id':
                        $key = 'condition';
                        $value = Condition::where('id', $value)->get('id')->first()->id;
                        break;
                    case 'unit_id':
                        $key = 'unit';
                        $value = Unit::where('id', $value)->get('id')->first()->id;
                        break;
                    case 'area_id':
                        $key = 'area';
                        $value = Area::where('id', $value)->get('id')->first()->id;
                        break;
                    case 'content':
                        $value = rtrim($value); // trailing breaklines
                        $value = str_replace(["\r", "\n"], '', $value); // breaklines except <br>
                        $value = br2nl($value); // turn <br> into \n
                        $value = strip_tags($value); // remove all html tags
                    default:
                        break;
                }

                $newListing->{$key} = $value;
            }
        }

        return $newListing;
    }

    public function edit(Listing $listing)
    {
        $categories = getCachedCategories();
        $conditions = Condition::all();
        $units = Unit::all();
        $areas = Area::where('area_id', NULL)->with('subareas')->get();

        return view('listings.edit')->with([
            'listing' => $this->modifyListingForEdit($listing),
            'categories' => $categories,
            'conditions' => $conditions,
            'units' => $units,
            'areas' => $areas,
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        if ($listing->user->id !== $request->user()->id) {
            return response()->json([
                'status' => 403,
                'message' => 'Pro tuto akci nemáte oprávnění.'
            ]);
        }


        $is_negotiable = $request->is_negotiable === '1';
        $is_price_in_content = $request->is_price_in_content === '1';
        $tax_included = $request->tax_included === '1';
        $price = $request->price;

        if ($is_negotiable || $is_price_in_content) {
            $price = null;
        }

        try {
            $listing->update([
                'title' => $request->title,
//                'slug' => Str::slug($request->title) . '-' . rand(1111, 9999),
                'category_id' => $request->category,
                'phone' => $request->phone,
                'price' => $price,
                'tax_included' => $tax_included,
                'is_negotiable' => $is_negotiable,
                'is_price_in_content' => $is_price_in_content,
                'content' => nl2br(strip_tags(rtrim($request->get('content')))),
                'is_active' => true,
                'is_approved' => false,
                'condition_id' => $request->condition,
                'unit_id' => $request->unit,
                'area_id' => $request->area,
                'amount' => $request->amount,
                'is_highlighted' => $request->filled('is_highlighted'),
            ]);

            event(new ListingUpdated($listing));

            return response()->json(['status' => 200, 'redirect_to' => route('listings.show', ['listing' => $listing->slug])]);


        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function my(Request $request)
    {
        $active_listings = new Collection();
        $inactive_listings = new Collection();
        $rejected_listings = new Collection();
        $waiting_listings = new Collection();

        foreach (auth()->user()->listings as $listing) {
            if ($listing->is_approved) {
                if ($listing->is_active) {
                    $active_listings->add($listing);
                } else {
                    $inactive_listings->add($listing);
                }
            } else {
                if ($listing->is_removed) {
                    $rejected_listings->add($listing);
                } else {
                    $waiting_listings->add($listing);
                }
            }
        }

        return view('listings.my', compact('active_listings', 'inactive_listings', 'rejected_listings', 'waiting_listings'));
    }

    public function approve(Request $request)
    {
        $listings_to_approve = Listing::where([
            ['is_removed', '=', false],
            ['is_approved', '=', false]
        ])
            ->with('category')
            ->get();

        return view('listings.approve', compact('listings_to_approve'));
    }

    public function approveYes(Listing $listing, Request $request)
    {
        if (Auth::user()->hasRole('admin')) {
            $listing->is_active = true;
            $listing->is_approved = true;
            $listing->is_removed = false;
            $listing->save();

            event(new ListingApproved($listing));

            Cache::forget('to_approve');

            return redirect()->back()->with(['message' => 'Inzerát byl schválen.']);
        }

        return redirect()->route('listings.show', $listing);
    }

    public function approveNo(Listing $listing, Request $request)
    {
        if (Auth::user()->hasRole('admin')) {
            $listing->is_active = false;
            $listing->is_approved = false;
            $listing->is_removed = true;

            // If listing was highlighted, return credits to the user
            if ($listing->is_highlighted) {
                $listing->is_highlighted = false;
                $listing->user->credit->increment('amount', env('PRICE_HIGHLIGHT'));
            }

            $listing->save();

            event(new ListingRejected($listing));

            return redirect()->back()->with(['message' => 'Inzerát byl zamítnut.']);
        }

        return redirect()->route('listings.show', $listing);
    }

    public function makeInactive(Listing $listing)
    {
        if (Auth::user()->hasRole('admin') || $listing->user->id === Auth::id()) {
            $listing->is_active = false;
            $listing->save();

            return redirect()->back()->with(['message' => 'Inzerát byl označen jako neaktivní.']);
        }

        return redirect()->route('listings.show', $listing);
    }

    public function makeActive(Listing $listing)
    {
        if (Auth::user()->hasRole('admin') || $listing->user->id === Auth::id()) {
            $listing->is_active = true;
            $listing->save();

            return redirect()->back()->with(['message' => 'Inzerát byl označen jako aktivní.']);
        }
    }

    public function removed(Request $request)
    {
        $listings = Listing::where('is_removed', true)->get();
        return view('listings.removed', compact('listings'));
    }

    public function remove(Listing $listing, Request $request)
    {
        $listing->delete();
        return redirect()->back()->with(['message' => 'Inzerát byl smazán.']);
    }

    public function highlightConfirm(Listing $listing)
    {
        // Fake highlight for preview
        $listing->is_highlighted = true;
        return view('listings.confirm-highlight')->with(compact('listing'));
    }

    public function highlight(Listing $listing, Request $request)
    {
        if (!$listing->is_highlighted) {
            $listing->is_highlighted = true;
            $listing->save();

            $user = $request->user();

            $user->credit->amount = $user->credit->amount - (int)env('PRICE_HIGHLIGHT');
            $user->credit->save();

            event(new CreditSpent($request->user()->credit, (int)env('PRICE_HIGHLIGHT'), 'highlight', $listing));
        }

        return redirect()->to(route('listings.show', $listing->slug));
    }
}
