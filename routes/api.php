<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// ANDROID ROUTES
Route::post('/android/auth/login', [App\Http\Controllers\Android\LoginController::class, 'login']);
Route::post('/android/auth/change-password', [App\Http\Controllers\Android\ChangePasswordController::class, 'changePassword']);
Route::get('/android/events', [App\Http\Controllers\Android\EventsController::class, 'eventsList']);
Route::get('/android/events/{id}', [App\Http\Controllers\Android\EventsController::class, 'show']);
//submit scanned
Route::post('/android/submit-scanned', [App\Http\Controllers\Android\EventsController::class, 'submitScanned']);

//check if open ang evaluation
Route::get('/android/check-if-open/{id}', [App\Http\Controllers\Android\EventsController::class, 'checkIfOpen']);
Route::get('/android/load-events', [App\Http\Controllers\Android\EventsController::class, 'loadEvents']);

Route::get('/android/load-questions', [App\Http\Controllers\Android\AndroidQuestionController::class, 'loadQuestions']);

Route::get('/android/load-legends', [App\Http\Controllers\Android\AndroidLegendController::class, 'loadLegends']);

//submit evaluation
Route::post('/android/evaluation/eval-submit', [App\Http\Controllers\Android\AndroidEvaluationController::class, 'store']);
Route::get('/android/evaluation/get-report-evaluation', [App\Http\Controllers\Android\AndroidEvaluationController::class, 'getReportEvaluation']);
