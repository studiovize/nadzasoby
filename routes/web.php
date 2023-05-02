<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SitemapController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListingController::class, 'index'])
    ->name('listings.index');

Route::get('/about', [Controller::class, 'about'])
    ->name('about');

Route::get('/faq', [Controller::class, 'faq'])
    ->name('faq');

Route::get('/docs/terms', [DocsController::class, 'terms'])
    ->name('docs.terms');

Route::get('/docs/personal-data', [DocsController::class, 'personalData'])
    ->name('docs.personal-data');

Route::group(['prefix' => 'cookies'], function () {
    Route::get('/settings', [CookieController::class, 'settings'])->name('cookies.settings');
    Route::post('/store', [CookieController::class, 'store'])->name('cookies.store');
});


Route::get('/install', function () {
//    Cache::flush();
//    generateAreas();
//    createAdmin();
//    generateCategories();
//    generatePlans();
//    generateConditions();
//    generateUnits();
});

Route::get('/create', [ListingController::class, 'create'])
    ->middleware(['auth'])
    ->name('listings.create');

Route::post('/create', [ListingController::class, 'store'])
    ->middleware(['auth'])
    ->name('listings.store');

// Dashboard
Route::get('/dashboard', [Controller::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

// Custom auth routes
Route::get('/register-personal', [RegisteredUserController::class, 'createPersonal'])
    ->middleware('guest')
    ->name('register-personal');

Route::post('/register-personal', [RegisteredUserController::class, 'storePersonal'])
    ->middleware('guest');

Route::get('/register-company', [RegisteredUserController::class, 'createCompany'])
    ->middleware('guest')
    ->name('register-company');

Route::post('/register-company', [RegisteredUserController::class, 'storeCompany'])
    ->middleware('guest');


// Contact form
Route::group(['prefix' => 'contact'], function () {
    Route::get('/', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/', [ContactController::class, 'store'])->name('contact.store');
});

// Messages
Route::group(['prefix' => 'messages', 'middleware' => 'auth'], function () {
    Route::get('/', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/create', [MessagesController::class, 'create'])->name('messages.create');
    Route::post('/', [MessagesController::class, 'store'])->name('messages.store');
    Route::get('/{id}', [MessagesController::class, 'show'])->name('messages.show');
    Route::put('/{id}', [MessagesController::class, 'update'])->name('messages.update');
});

Route::get('/search', [ListingController::class, 'search'])
    ->name('listings.search');

Route::get('/credits', [CreditController::class, 'index'])
    ->name('credits.index');

// Payments
Route::group(['prefix' => 'payments'], function () {
    Route::get('/create/{plan}', [PaymentController::class, 'create'])->name('payments.create');
    Route::get('/payment-link', [PaymentController::class, 'createPaymentLink'])->name('payments.payment-link');
    Route::get('/payment-link/confirmation', [PaymentController::class, 'verifyPaymentResponse'])->name('payments.payment-link.confirmation');
});

// Plans
Route::get('/plans/{plan}', [PlanController::class, 'show'])
    ->name('plans.show');


Route::get('/my-listings', [ListingController::class, 'my'])
    ->middleware('auth')->name('listings.my');

// Admin stats
Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}', [AdminController::class, 'usersShow'])->name('admin.users.show');
});

// Approve listings
Route::group(['prefix' => 'approve', 'middleware' => 'permission:approve listings'], function () {
    Route::get('/', [ListingController::class, 'approve'])->name('listings.approve');
    Route::get('/{listing}/yes', [ListingController::class, 'approveYes'])->name('listings.approve.yes');
    Route::get('/{listing}/no', [ListingController::class, 'approveNo'])->name('listings.approve.no');
});

Route::get('/removed', [ListingController::class, 'removed'])
    ->middleware('permission:approve listings')
    ->name('listings.removed');

Route::get('/remove/{listing}', [ListingController::class, 'remove'])
    ->middleware('role:admin')
    ->name('listings.remove');

Route::get('/{listing}', [ListingController::class, 'show'])
    ->middleware('add_listing_view')
    ->name('listings.show');

Route::get('/{listing}/highlight-confirm', [ListingController::class, 'highlightConfirm'])
    ->middleware('auth', 'owns_listing', 'not_highlighted')
    ->name('listings.highlight-confirm');

Route::get('/{listing}/highlight', [ListingController::class, 'highlight'])
    ->middleware('auth', 'owns_listing', 'not_highlighted', 'can_afford_highlight')
    ->name('listings.highlight');

Route::get('/{listing}/edit', [ListingController::class, 'edit'])
    ->middleware('auth', 'owns_listing')
    ->name('listings.edit');

Route::post('/{listing}/edit', [ListingController::class, 'update'])
    // todo: fix owns_listing
//    ->middleware('auth', 'owns_listing')
    ->middleware('auth')
    ->name('listings.update');

Route::get('/{listing}/apply', [ListingController::class, 'apply'])
    ->middleware('auth', 'has_unlocked')
    ->name('listings.apply');

Route::get('/{listing}/unlock', [ListingController::class, 'confirmUnlock'])
    ->middleware(['auth', 'has_credit'])
    ->name('listings.confirm-unlock');

Route::post('/{listing}/unlock', [ListingController::class, 'unlock'])
    ->middleware(['auth', 'has_credit'])
    ->name('listings.unlock');

Route::get('/{listing}/make-inactive', [ListingController::class, 'makeInactive'])
    ->middleware(['auth'])
    ->name('listings.make-inactive');

Route::get('/{listing}/make-active', [ListingController::class, 'makeActive'])
    ->middleware(['auth'])
    ->name('listings.make-active');


// CRON routes
Route::group(['prefix' => 'cron'], function () {
    Route::get('/expired-credit', [CreditController::class, 'expiredCredit'])
        ->name('cron.expired-credit');

    Route::get('/sitemap', [SitemapController::class, 'generate'])
        ->name('cron.sitemap');
});

// DEV
if (env('APP_ENV') === 'local') {
    Route::group(['prefix' => 'dev'], function () {
        Route::get('email', function () {
            $listing = Listing::first();
            return new \App\Mail\ListingCreatedAdmin($listing);
        });

        Route::get('fix-tracking', function () {
//            $unlocked = DB::table('listing_user')->where('user_id', 26)->get();
//
//            foreach ($unlocked as $key => $row) {
//                $user = User::find(26);
//
//                $tracker = Tracker::create([
//                    'user_id' => 26,
//                    'action' => 'spent credit',
//                    'data' => [
//                        'amount' => 1,
//                        'remaining' => $user->credit->amount,
//                        'reason' => 'unlock',
//                        'listing_id' => $row->listing_id
//                    ]
//                ]);
//            }

        });
    });
}
