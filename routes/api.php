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

// API routes without token
Route::middleware('api')->group(function () {

    // Auth routes
    Route::prefix('auth')->group(function () {

        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout');

    });

});

// API routes with token
Route::middleware('auth:sanctum')->group(function () {

    // Current user route
    Route::get('user', 'AuthController@user');

    // Category routes
    Route::resource('categories', 'CategoriesController')
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    // Dish routes
    Route::resource('dishes', 'DishesController')
        ->only(['index', 'store', 'show', 'update', 'destroy']);

});
