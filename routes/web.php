<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\chatController;

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
 
Route::get('/dev', function () {
    \Artisan::call('optimize:clear');
});

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/widget', function () {
    return view('widget');
})->name('widget');


// Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // });
    Route::resource('/chat',chatController::class)->names([
        'index' => 'dashboard.chat',
        'create' => 'products.new',
        'show' => 'products.view',
        'edit' => 'products.modify'
    ]);



/**
 * for home controller
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/currency_calculate', 'HomeController@currency_calculate');
    Route::get('/check_email/{email}', 'TokenController@check_email')->name('check_email');
    Route::get('/fetch_data/{email}', 'TokenController@fetch_data')->name('fetch_data');
    Route::get('/fetch_hash/{email}', 'TokenController@fetch_hash')->name('fetch_hash');
});

/**
 * for dashboard profile
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/profile', 'ProfileController@profile')->name('dashboard.profile');
    Route::post('/password/change', 'ProfileController@passwordChange')->name('password.change');
    Route::post('/image/update/{id}', 'ProfileController@updateImage')->name('image.update');
    Route::post('/name/change', 'ProfileController@nameChange')->name('name.change');
    Route::post('/info/change', 'ProfileController@infoChange')->name('info.change');
    Route::get('tokens_dashboard', 'ProfileController@tokens_dashboard')->name('dashboard.tokens_dashboard');
});

/**
 * for dashboard help
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/help', 'HelpController@help')->name('dashboard.help');
    Route::post('/help/create', 'HelpController@createHelp')->name('dashboard.createHelp');
});

/**
 * for dashboard referral
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/referral', 'ReferralController@referral')->name('dashboard.referral');
});

/**
 * active email using route
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/email/{token}', 'MailConfirmController@confirmEmail')->name('email.confirm');
});

/**
 * for all payment
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/register/payment', 'PaymentController@payment')->name('register.payment');
    Route::get('/saro', 'PaymentController@saroemail');
    Route::get('/verify', 'PaymentController@verifyPayment')->name('payment.verify');
	Route::get('/coinbase', 'PaymentController@coinbasePayment')->name('payment.coinbase');
	Route::post('/verify_stripe', 'PaymentController@stripePayment')->name('payment.verify_stripe');
});

/**
 * for pool controller
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/pool', 'PoolController@pool')->name('dashboard.pool');
});

/**
 * for wallet controller
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/wallet', 'WalletController@wallet')->name('dashboard.wallet');
});

/**
 * for package controller
 */
Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => 'packages'], function () {
    Route::get('/{id}', 'PackageController@createSession')->name('packages.session');
    Route::get('/', 'PackageController@index')->name('packages.index');
    Route::post('/create', 'PackageController@create')->name('packages.create');
});

/**
 * user controller
 */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::post('/users/allUsers', 'UserController@getAllUser')->name('allusers');
});

/**
 * translator localization
 */
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::get('lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    return redirect()->route('packages.index');
});

/**
 * payment status route
 */
Route::post(
    '/coinbase/webhook',
    '\App\Http\Controllers\PaymentController@handle_webhook'
);

Route::post('verify_paypal_webhook', 'App\Http\Controllers\PaymentController@handle_webhook_paypal')->name('verify_paypal_webhook');

Route::get("decrypt", function() {
    $user = User::find(1);
    $password = $user->password;
    dd(Crypt::decrypt($password));
});

// Route for adding contact

Route::post("/addContact/{user:username}", function(User $user) {
    // $contact_user = request()->input("contact_id");
    // $user->contacts()->attach($user->id);
    // $contact_id = User::where("username", $contact_user)->first();
    try {
        $loggedIn = auth()->user()->contacts()->attach($user);
    } catch(\Exception $e) {
        request()->session()->flash("error", "Already in the contact list!");
        return redirect()->back();
    }
    request()->session()->flash("success", "Added in contact list!");
    return redirect()->back();
});

Route::get("makeMigration", function() {
    $output = Artisan::call("migrate");
    dd($output);
});
Route::get('makegroup', function () {
    // Get the absolute path to the Laravel application's root directory
    $appPath = base_path();

    // Construct the full path to the artisan file
    $artisanPath = "{$appPath}/artisan";

    // Execute the make:migration command using the full path to artisan
    $output = shell_exec("php {$artisanPath} make:controller group_controller --resource");
    
    dd($output);
})->name('makegroup');

Route::get("create", function() {
    User::create([
        "username" => "hashim",
        "email" => "kaka@gmail.com",
        "first_name" => "hashim",
        "last_name" => "abbas",
        "photo" => "7bf862695cdeed72f7c54c5e485a0c87.jpg",
        "cell" => "484",
        "role" => "customer",
        "password" => Hash::make("lol_password"),
        "payment_status" => 2,
        "status" => "pending"
    ]);
});




Auth::routes();
