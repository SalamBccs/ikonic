<?php

use App\Http\Controllers\API\ContactUsController;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register student routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

Route::post('addcontact', [ContactUsController::class, 'stored']);





