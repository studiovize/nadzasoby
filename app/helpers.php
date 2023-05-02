<?php

use App\Models\Area;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Listing;
use App\Models\Plan;
use App\Models\Unit;
use App\Models\User;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

function svg($path): string
{
    $fullPath = public_path($path);

    if (!File::exists($fullPath)) {
        return '!!!' . $fullPath . '!!!';
    }

    return File::get($fullPath);
}

function br2nl($str)
{
    $pattern = "/<br ?\/?>/m";
    return preg_replace($pattern, '\n', $str);
}

function generateBreadcrumbs($listing): array
{
    $category = $listing->category;

    $items = [
        // homepage
        [
            'link' => route('listings.index'),
            'label' => 'Nadzásoby'
        ],

        // category
        [
            'link' => route('listings.search', ['category' => $category->id]),
            'label' => $category->name
        ]
    ];

    return [
        'items' => $items,
        'divider' => svg('icons/divider.svg')
    ];
}

function generateAreas()
{
    $a = 'Benešov (Středočeský kraj)
Beroun (Středočeský kraj)
Blansko (Jihomoravský kraj)
Brno-město (Jihomoravský kraj)
Brno-venkov (Jihomoravský kraj)
Bruntál (Moravskoslezský kraj)
Břeclav (Jihomoravský kraj)
Česká Lípa (Liberecký kraj)
České Budějovice (Jihočeský kraj)
Český Krumlov (Jihočeský kraj)
Děčín (Ustecký kraj)
Domažlice (Plzeňský kraj)
Frýdek-Místek (Moravskoslezský kraj)
Havlíčkův Brod (Kraj Vysočina)
Hodonín (Jihomoravský kraj)
Hradec Králové (Královéhradecký kraj)
Cheb (Karlovarský kraj)
Chomutov (Ustecký kraj)
Chrudim (Pardubický kraj)
Jablonec nad Nisou (Liberecký kraj)
Jeseník (Olomoucký kraj)
Jičín (Královéhradecký kraj)
Jihlava (Kraj Vysočina)
Jindřichův Hradec (Jihočeský kraj)
Karlovy Vary (Karlovarský kraj)
Karviná (Moravskoslezský kraj)
Kladno (Středočeský kraj)
Klatovy (Plzeňský kraj)
Kolín (Středočeský kraj)
Kroměříž (Zlínský kraj)
Kutná Hora (Středočeský kraj)
Liberec (Liberecký kraj)
Litoměřice (Ustecký kraj)
Louny (Ustecký kraj)
Mělník (Středočeský kraj)
Mladá Boleslav (Středočeský kraj)
Most (Ustecký kraj)
Náchod (Královéhradecký kraj)
Nový Jičín (Moravskoslezský kraj)
Nymburk (Středočeský kraj)
Olomouc (Olomoucký kraj)
Opava (Moravskoslezský kraj)
Ostrava-město (Moravskoslezský kraj)
Pardubice (Pardubický kraj)
Pelhřimov (Kraj Vysočina)
Písek (Jihočeský kraj)
Plzeň-jih (Plzeňský kraj)
Plzeň-město (Plzeňský kraj)
Plzeň-sever (Plzeňský kraj)
Praha (Hlavní město Praha)
Praha-východ (Středočeský kraj)
Praha-západ (Středočeský kraj)
Prachatice (Jihočeský kraj)
Prostějov (Olomoucký kraj)
Přerov (Olomoucký kraj)
Příbram (Středočeský kraj)
Rakovník (Středočeský kraj)
Rokycany (Plzeňský kraj)
Rychnov nad Kněžnou (Královéhradecký kraj)
Semily (Liberecký kraj)
Sokolov (Karlovarský kraj)
Strakonice (Jihočeský kraj)
Svitavy (Pardubický kraj)
Šumperk (Olomoucký kraj)
Tachov (Plzeňský kraj)
Tábor (Jihočeský kraj)
Teplice (Ustecký kraj)
Trutnov (Královéhradecký kraj)
Třebíč (Kraj Vysočina)
Uherské Hradiště (Zlínský kraj)
Ústí nad Labem (Ustecký kraj)
Ústí nad Orlicí (Pardubický kraj)
Vsetín (Zlínský kraj)
Vyškov (Jihomoravský kraj)
Zlín (Zlínský kraj)
Znojmo (Jihomoravský kraj)
Žďár nad Sázavou (Kraj Vysočina)';

    $array = preg_split("/\r\n|\n|\r/", $a);
    $areas = [];

    foreach ($array as $ar) {
        $boom = explode(' (', $ar);
        $subarea = $boom[0];
        $area = substr($boom[1], 0, -1);
        $areas[$area][] = $subarea;
    }

    ksort($areas, SORT_LOCALE_STRING);

    //

    foreach ($areas as $area => $subareas) {

        if ($area === 'Ustecký kraj') {
            $area = 'Ústecký kraj';
        }
        $area_slug = Str::slug($area);

        $area_id = Area::insertGetId([
            'name' => $area,
            'slug' => $area_slug,
            'parent_id' => 0
        ]);

        foreach ($subareas as $subarea) {
            $subarea_slug = Str::slug($subarea);
            $subarea_id = Area::insertGetId([
                'name' => $subarea,
                'slug' => $subarea_slug,
                'parent_id' => $area_id
            ]);
        }
    }

    echo 'Areas generated.<br>';
//    dd($areas);
}

function createAdmin()
{
    $role = Role::create(['name' => 'admin']);
    $permission = Permission::create(['name' => 'approve listings']);

    $role->givePermissionTo($permission);

    $user = User::where('email', 'info@mihailo.cz')->first();

    $user->assignRole('admin');
//    $a = User::role('admin')->get();
//    dd($a);
    echo 'Admin created.<br>';
}

function generateCategories()
{
    $categories = [
        'Auto-moto',
        'Drogerie a kosmetika',
        'Dům a byt',
        'Elektro',
        'Galanterie a textil',
        'Chovatelské potřeby',
        'Kancelářské potřeby a papírnictví',
        'Oděvy',
        'Potraviny',
        'Služby',
        'Stavebniny, dílna, zahrada a dřevo',
        'Zdraví a zdravotní pomůcky',
    ];

    foreach ($categories as $cat) {
        Category::insertGetId([
            'name' => $cat,
            'slug' => Str::slug($cat)
        ]);
    }

    echo 'Categories generated.<br>';
}

function generatePlans()
{
    $plans = [
        [
            'credits' => 20,
            'extra' => 0,
            'price' => 200,
        ],
        [
            'credits' => 50,
            'extra' => 5,
            'price' => 400,
        ],
        [
            'credits' => 100,
            'extra' => 10,
            'price' => 700,
        ],
    ];

    foreach ($plans as $plan) {
        Plan::create($plan);
    }

    echo 'Plans generated.<br>';
}

function generateConditions()
{

    $conditions = [
        ['name' => 'Nové', 'slug' => '	nove'],
        ['name' => 'Poškozený obal', 'slug' => ' poskozeny-obal'],
        ['name' => 'Poškozené zboží', 'slug' => 'poskozene-zbozi'],
        ['name' => 'Použité', 'slug' => 'pouzite'],
        ['name' => 'Zánovní', 'slug' => 'zanovni'],
    ];


    foreach ($conditions as $condition) {
        Condition::create($condition);
    }

    echo 'Conditions generated.<br>';
}

function generateUnits()
{

    $units = [
        [
            'name' => 'Kilogramy',
            'name_short' => 'kg',
            'name_one' => 'kilogram',
            'name_few' => 'kilogramy',
            'name_many' => 'kilogramů'
        ],
        [
            'name' => 'Metry',
            'name_short' => 'm',
            'name_one' => 'metr',
            'name_few' => 'metry',
            'name_many' => 'metrů'
        ],
        [
            'name' => 'Palety',
            'name_short' => 'palety',
            'name_one' => 'paleta',
            'name_few' => 'palety',
            'name_many' => 'palet'
        ],
    ];


    foreach ($units as $unit) {
        Unit::create($unit);
    }

    echo 'Units generated.<br>';
}

function in_array_all($needles, $haystack): bool
{
    return empty(array_diff($needles, $haystack));
}

function in_array_any($needles, $haystack): bool
{
    return !empty(array_intersect($needles, $haystack));
}

function getAdminEmails()
{
    return json_decode(env('ADMIN_EMAILS'));
}

function timeInMilis()
{
    list($usec, $sec) = explode(" ", microtime());
    $data = ((float)$usec + (float)$sec);
    return substr(str_replace(".", "", $data), 0, 12);
}

function getTitleSuffix()
{
    return ' - ' . config('app.name', 'Nadzásoby') . ' - V nadzásobách vám leží peníze. Nadzásoby za super peníze.';
}

function title($title)
{
    return $title . getTitleSuffix();
}

function didSetCookies()
{
    return isset($_COOKIE['nadzasoby_cookies']);
}


function grantedCookieSettings($needle)
{
    $haystack = json_decode($_COOKIE['nadzasoby_cookies']);
    return $haystack->{$needle} === 'granted';
}

function getCookieSettings($needle)
{
    if ($needle === 'required') return 'granted';
    if (!didSetCookies()) return 'denied';
    return grantedCookieSettings($needle) ? 'granted' : 'denied';
}

function getCachedCategories()
{
    return Cache::remember('categories_all', now()->addDay(), function () {
        return Category::all();
    });
}

function getCachedAreas()
{
    return Cache::remember('areas_all', now()->addDay(), function () {
        return Area::all();
    });
}

function getFakePopularSearches($count = 0)
{
    $data = [];

    $categories = getCachedCategories();
    $areas = getCachedAreas();

    for ($i = 0; $i < $count; $i++) {
        $category = $categories[rand(0, $categories->count() - 1)];
        $area = $areas[rand(0, $areas->count() - 1)];

        $data[] = getPopularSearchLink($category, $area);
    }

    return $data;
}

function getPopularSearchLink($category, $area)
{
    return [
        'label' => $category->name . ' - ' . $area->name,
        'link' => route('listings.search') . '?area=' . $area->id . '&category=' . $category->id
    ];
}

function getPopularSearches($count = 5)
{
    return Cache::remember('popular_searches', now()->addDay(), function () use ($count) {
        $popular = DB::table('searches')
            ->select(DB::raw('count(*) as count, category_id, area_id'))
            ->groupBy('category_id', 'area_id')
            ->orderBy('count', 'desc')
            ->limit($count)
            ->get();

        $categories = getCachedCategories();
        $areas = getCachedAreas();

        $popular = $popular->map(function ($item) use ($categories, $areas) {
            $category = $categories->where('id', $item->category_id)->first();
            $area = $areas->where('id', $item->area_id)->first();

            return getPopularSearchLink($category, $area);
        });

        if ($popular->count() < $count) {
            $fake = getFakePopularSearches($count - $popular->count());
            $popular = $popular->merge($fake);
        }

        return $popular;
    });
}

function canonical_url()
{
//    $current = url()->full();
    $current = url()->current();

    if (Str::startsWith($current, 'http://')) {
        $current = str_replace('http://', 'https://', $current);
    }

    if (!Str::startsWith($current, 'https://www.')) {
        $current = str_replace('https://', 'https://www.', $current);
    }

    return $current;
}


function getPlural($amount, $one, $few, $manyOrNone)
{
    if ($amount === 1) return $one;
    if ($amount >= 2 && $amount <= 4) return $few;
    return $manyOrNone;
}

function getTrackerActionForHumans($val)
{
    switch ($val) {
        case 'added credit':
            return 'Zvýšení kreditu';
        case 'approved listing':
            return 'Schválení inzerátu';
        case 'created listing':
            return 'Vytvoření inzerátu';
        case 'credit reminder':
            return 'Připomenutí kreditů';
        case 'credit expired':
            return 'Vypršení kreditů';
        case 'registration':
            return 'Registrace';
        case 'rejected listing':
            return 'Zamítnutí inzerátu';
        case 'sent message':
            return 'Odpověď na inzerát';
        case 'spent credit':
            return 'Snížení kreditu';
        case 'updated listing':
            return 'Úprava inzerátu';
        default:
            return 'Neznámé';
    }
}

function getTrackerDataForHumans($tracker)
{
    $action = $tracker->action;
    $data = $tracker->data;

    $res = '';

    switch ($action) {
        case 'added credit':
            if ($data['reason'] === 'payment') {
                $res .= 'Zakoupeno ' . $data['amount'] . ' + ' . $data['extra'] . ' kreditů';
            } else if ($data['reason'] === 'registration') {
                $res .= 'Získáno ' . $data['amount'] . ' kreditů za registraci';
            }
            break;
        case 'approved listing':
        case 'created listing':
        case 'rejected listing':
            $listing = \App\Models\Listing::where('id', $data['listing_id'])->first();
            if (!$listing) {
                $res .= 'Inzerát č. ' . $data['listing_id'] . ' (smazáno)';
            } else {
                $res .= '<a href="' . route('listings.show', $listing->slug) . '" class="text-red-500 underline hover:no-underline font-bold" target="_blank">';
                $res .= $listing->title;
                $res .= '</a>';
            }
            break;
        case 'registration':
            $res .= $tracker->user->name;
            break;
        case 'sent message':
            $thread = Thread::find($data['thread_id']);
            if (!$thread) {
                $res .= 'Vlákno č. ' . $data['thread_id'] . ' (smazáno)';

            } else {
                $listing = Listing::find($thread->listing_id);
                $res .= 'Odpověď na ';

                if (!$listing) {
                    $res .= 'Inzerát č. ' . $thread->listing_id . ' (smazáno)';
                } else {
                    $res .= '<a href="' . route('listings.show', $listing->slug) . '" class="text-red-500 underline hover:no-underline font-bold" target="_blank">';
                    $res .= $listing->title;
                    $res .= '</a>';
                }
            }
            break;
        case 'spent credit':
            $listing = \App\Models\Listing::where('id', $data['listing_id'])->first();

            $res .= 'Utraceno ' . $data['amount'] . ' kreditů za ';
            $res .= $data['reason'] === 'highlight' ? 'topování ' : 'odemknutí ';

            if (!$listing) {
                $res .= 'inzerátu č. ' . $data['listing_id'] . ' (smazáno)';
            } else {
                $res .= '<a href="' . route('listings.show', $listing->slug) . '" class="text-red-500 underline hover:no-underline font-bold" target="_blank">';
                $res .= 'inzerátu';
                $res .= '</a>';
            }
            $res .= ', zbývá ' . $data['remaining'];
            break;
        case 'credit reminder':
            $res .= 'Odeslán e-mail, že ' . Carbon::parse($data['expiration_date'])->format('d.m.Y') . ' vyprší ' . $data['amount'] . ' kreditů';
            break;
        case 'credit expired':
            $res .= Carbon::parse($data['expiration_date'])->format('d.m.Y') . ' vypršelo ' . $data['amount'] . ' kreditů';
            break;
        default:
            $res = 'Neznámá data';
            break;
    }

    return $res;
}

function getUserDataForAdmin($user)
{
    $user_formatted = [
        'id' => $user->id,
        'role' => $user->hasRole('admin') ? 'Admin' : 'Uživatel',
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone ?? '-',
        'type' => $user->type === 'personal' ? 'Osobní' : 'Firemní',
        'ico' => $user->ico ?? '-',
        'created_at' => $user->created_at->format('d.m.Y H:i')
    ];

    $credit = $user->credit;

    $credit_formatted = [
        'amount' => $credit->amount,
        'expiration_date' => $credit->expiration_date ? $credit->expiration_date->format('d.m.Y') : '-'
    ];

    $user_history = $user->trackers()->orderBy('created_at', 'DESC')->get();

    $spending_history = $user_history->filter(function ($item) {
//        return $item->action === 'spent credit';
        return $item->action === 'added credit' || $item->action === 'spent credit';
    });

    $spending_history_formatted = $spending_history->map(function ($item) {
        return (object)[
            'created_at' => $item->created_at->format('d.m.Y H:i'),
            'data' => getTrackerDataForHumans($item)
        ];
    });

    $payments = $user->payments()->where('status', 'success')->with('plan')->get();

    $payments_formatted = $payments->map(function ($item) {
        return (object)[
            'created_at' => $item->created_at->format('d.m.Y H:i'),
            'credits' => $item->plan->credits,
            'extra' => $item->plan->extra,
            'price_formatted' => $item->plan->price_formatted
        ];
    });

    $total_paid = $user->total_paid_formatted;

    $listings = $user->listings;

    $listings_formatted = $listings->map(function ($item) {
        return (object)[
            'created_at' => $item->created_at->format('d.m.Y'),
            'status' => $item->status,
            'link' => route('listings.show', $item->slug),
            'title' => $item->title
        ];
    });

    return [
        'user' => (object)$user_formatted,
        'credit' => (object)$credit_formatted,
        'history' => $user_history,
        'spending_history' => $spending_history_formatted,
        'payments' => $payments_formatted,
        'total_paid' => $total_paid,
        'listings' => $listings_formatted
    ];
}

function getToApproveCount()
{
    return Cache::remember('to_approve', now()->addHour(), function () {
        return Listing::where([
            ['is_removed', '=', false],
            ['is_approved', '=', false]
        ])->count();
    });
}
