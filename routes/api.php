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

});
require __DIR__.'/auth.php';
