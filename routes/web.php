<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ContactUsController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
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


Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    dd('clear done');
});


Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('signup', [AuthController::class, 'signup']);

Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::group(['middleware' => 'inactivity'], function () {

            Route::get('getFeedback', [FeedbackController::class, 'index']);
            Route::post('addfeedback', [FeedbackController::class, 'store']);
            Route::post('add-comment/{id}', [CommentController::class, 'store']);
        
        Route::post('logout', [AuthController::class, 'logout']);

    });
});


Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');

