<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes([
    'login' => true,
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);



Route::get('/get-user', function(){
    if(Auth::check()){
        return Auth::user();
    }

    return [];
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ADDRESS
//Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
//Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
//Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);



Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);

Route::get('/load-academic-years', [App\Http\Controllers\OpenAcademicYearController::class, 'loadAcademicYears']);


/*     ADMINSITRATOR          */
Route::middleware(['auth', 'admin'])->group(function() {


    Route::resource('/academic-years', App\Http\Controllers\Administrator\AcademicYearController::class);
    Route::get('/get-academic-years', [App\Http\Controllers\Administrator\AcademicYearController::class, 'getData']);
    Route::post('/academic-year-set-active/{id}', [App\Http\Controllers\Administrator\AcademicYearController::class, 'setActive']);



    Route::resource('/dashboard', App\Http\Controllers\Administrator\DashboardController::class);

    Route::resource('/events', App\Http\Controllers\Administrator\EventController::class);
    Route::post('/events-update/{id}', [App\Http\Controllers\Administrator\EventController::class, 'updateEvent']);
    Route::get('/get-events', [App\Http\Controllers\Administrator\EventController::class, 'getEvents']);


    Route::resource('/questions', App\Http\Controllers\Administrator\QuestionController::class);
    Route::get('/get-questions', [App\Http\Controllers\Administrator\QuestionController::class, 'getQuestions']);
    Route::get('/get-browse-events', [App\Http\Controllers\Administrator\QuestionController::class, 'getBrowseEvents']);




});
/*     ADMINSITRATOR          */




Route::middleware(['auth', 'student'])->group(function() {
    Route::resource('/event-feeds', App\Http\Controllers\User\UserEventFeedController::class);
    Route::get('/load-event-feeds', [App\Http\Controllers\User\UserEventFeedController::class, 'loadEventFeeds']);

    Route::resource('/profile', App\Http\Controllers\User\UserProfileController::class);
    Route::get('/load-profile', [App\Http\Controllers\User\UserProfileController::class, 'loadProfile']);

});








// ANDROID ROUTES
Route::post('/api/android/auth/login', [App\Http\Controllers\Android\LoginController::class, 'login']);
Route::post('/api/android/auth/change-password', [App\Http\Controllers\Android\ChangePasswordController::class, 'changePassword']);
Route::get('/api/android/events', [App\Http\Controllers\Android\EventsController::class, 'eventsList']);
Route::get('/api/android/events/{id}', [App\Http\Controllers\Android\EventsController::class, 'show']);



Route::get('/session', function(){
    return Session::all();
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();
});
