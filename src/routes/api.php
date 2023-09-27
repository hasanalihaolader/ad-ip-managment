<?php

use App\Http\Controllers\IpManagementController;
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



Route::group(['middleware' => 'auth.service'], function () {
    Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'as' => 'api.'], function () {
        Route::group(['prefix' => 'ip', 'as' => 'ip.'], function () {
            Route::get('/', [IpManagementController::class, 'get'])->name('list');
            Route::post('/store', [IpManagementController::class, 'createOrUpdate'])->name('create');
            Route::patch('/update/{id}', [IpManagementController::class, 'createOrUpdate'])->name('update');
            Route::get('/{id}', [IpManagementController::class, 'getById'])->name('getById');
        });
    });
});
