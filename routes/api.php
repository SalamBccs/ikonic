<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountSettingController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ContactUsController;
use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;

Route::get('clear', function () {
    Artisan::call('schedule:run');
    dd("schedule run successfully.");
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('signup', [AuthController::class, 'signup']);



Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['middleware' => 'inactivity'], function () {

        Route::group(['middleware' => 'role:student'], function () {

            Route::get('getFeedback', [FeedbackController::class, 'index']);

            Route::post('addfeedback', [FeedbackController::class, 'store']);

            Route::post('add-comment/{id}', [CommentController::class, 'store']);
        
            Route::post('logout', [AuthController::class, 'logout']);
           
            Route::post('logout', [AuthController::class, 'logout']);


        });
    });
});
