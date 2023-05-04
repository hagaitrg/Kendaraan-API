<?php

use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function(){
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);

    Route::group(['middleware'=>['jwt.verify']], function(){
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('refresh', [UserController::class, 'refresh']);

        Route::prefix('kendaraans')->group(function(){
            Route::get('/', [KendaraanController::class, 'stockKendaraan']);
            Route::post('/mobil', [KendaraanController::class, 'storeMobil']);
            Route::post('/motor', [KendaraanController::class, 'storeMotor']);
        });

        Route::prefix('penjualans')->group(function(){
            Route::post('/{kendaraanId}', [KendaraanController::class, 'penjualan']);
        });
    });
});
