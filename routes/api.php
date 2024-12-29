<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\CheckoutController;


Route::apiResource('/v1/users', App\Http\Controllers\Api\UserController::class);
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/v1/login', [App\Http\Controllers\Api\UserController::class, 'login']);

Route::get('/v1/items', [App\Http\Controllers\Api\ItemController::class, 'index']);
Route::post('/v1/items', [App\Http\Controllers\Api\ItemController::class, 'store']);

Route::get('/v1/items/{itemId}', [App\Http\Controllers\Api\ItemController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
