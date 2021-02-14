<?php

use App\Http\Controllers\Api\ApiUserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [ApiUserController::class, 'login']);
Route::post('/register', [ApiUserController::class, 'register']);
Route::get('/logout', [ApiUserController::class, 'logout'])->middleware('auth:api');
Route::resource('user', ApiUserController::class)->middleware('auth:api');
