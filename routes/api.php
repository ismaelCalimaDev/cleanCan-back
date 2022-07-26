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
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'getLoggedUserProfile']);
    Route::put('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'updateProfile']);

    Route::get('/locations', [\App\Http\Controllers\LocationController::class, 'getLoggedUserLocations']);
    Route::post('/create/location', [\App\Http\Controllers\LocationController::class, 'createLocation']);
    Route::put('/edit/location/{id}', [\App\Http\Controllers\LocationController::class, 'editLocation']);
    Route::delete('/delete/location/{id}', [\App\Http\Controllers\LocationController::class, 'deleteLocation']);
    Route::get('/location/{id}', [\App\Http\Controllers\LocationController::class, 'getLocation']);

    Route::get('/cars', [\App\Http\Controllers\CarsController::class, 'getLoggedUserCars']);
    Route::post('/create/car', [\App\Http\Controllers\CarsController::class, 'createCar']);
    Route::put('/edit/car/{id}', [\App\Http\Controllers\CarsController::class, 'editCar']);
    Route::delete('/delete/car/{id}', [\App\Http\Controllers\CarsController::class, 'deleteCar']);
    Route::get('/car/{id}', [\App\Http\Controllers\CarsController::class, 'getCar']);

    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'getProducts']);
    Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'getProductById']);

    Route::get('/my-orders', [\App\Http\Controllers\OrderController::class, 'getMyOrders']);

});
Route::get('/common-questions', [\App\Http\Controllers\QuestionsController::class, 'getCommonQuestions']);
require __DIR__.'/auth.php';
