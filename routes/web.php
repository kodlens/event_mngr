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

/*     ADMINSITRATOR          */
Route::middleware(['auth', 'admin'])->group(function() {

    Route::resource('/dashboard', App\Http\Controllers\Administrator\DashboardController::class);

    Route::resource('/events', App\Http\Controllers\Administrator\EventController::class);
    Route::post('/events-update/{id}', [App\Http\Controllers\Administrator\EventController::class, 'updateEvents']);

    Route::get('/get-events', [App\Http\Controllers\Administrator\EventController::class, 'getEvents']);


});
/*     ADMINSITRATOR          */




Route::middleware(['auth', 'student'])->group(function() {
    Route::resource('/event-feeds', App\Http\Controllers\User\UserEventFeedController::class);
    Route::get('/load-event-feeds', [App\Http\Controllers\User\UserEventFeedController::class, 'loadEventFeeds']);


});



Route::get('/session', function(){
    return Session::all();
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();
});
