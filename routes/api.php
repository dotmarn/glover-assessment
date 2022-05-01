<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UsersController;
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

Route::controller(AuthController::class)->group(function() {

    Route::prefix('/auth')->group(function() {

        Route::post('/login', 'login')->name('login');

        Route::post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');

    });

});

Route::controller(UsersController::class)->group(function() {

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function() {

        Route::post('/create-user', 'create')->name('create');

        Route::get('/fetch-pending-request', 'view')->name('view');

    });

});
