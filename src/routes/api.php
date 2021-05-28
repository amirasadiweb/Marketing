<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\AuthController;
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
    return 'ok';
});



Route::prefix('v1')->group(function () {

    #region Auth
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    #end region


    #region Products
    Route::get('/show', [ProductsController::class, 'show'])->name('AllProducts');
    Route::post('/create', [ProductsController::class, 'store'])->name('CreateProducts')->middleware('auth:sanctum');
    Route::post('/edit/{product}', [ProductsController::class, 'update'])->name('UpdateProducts')->middleware('auth:sanctum');
    Route::delete('/delete/{product}', [ProductsController::class, 'destroy'])->name('DeleteProducts')->middleware('auth:sanctum');
    #end region


});
