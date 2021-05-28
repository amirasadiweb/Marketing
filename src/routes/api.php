<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\MarketsController;
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


    #region Marketing
    Route::get('/show/market', [MarketsController::class, 'show_market'])->name('ShowMarketing')->middleware('auth:sanctum');
    Route::post('/create/link', [MarketsController::class, 'create_link'])->name('CreateLink')->middleware('auth:sanctum');
    Route::get('/social-network', [MarketsController::class, 'show_social'])->name('SocialNetwork');
    Route::get('/visit/{link}', [MarketsController::class, 'visit'])->name('Visit');
    Route::post('/report-market', [MarketsController::class, 'report'])->name('Report')->middleware('auth:sanctum');

    #end region


});
