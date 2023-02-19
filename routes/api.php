<?php

use App\Http\Controllers\API\V1\ProjectAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->as('api.v1.')->group(function () {
    Route::prefix('projects')
        ->as('projects.')
        ->controller(ProjectAPIController::class)
        ->group(function () {
        Route::post('/', 'store')->name('store');
        Route::get('{project}', 'show')->name('show');
        Route::put('{project}', 'update')->name('update');
        Route::delete('{project}', 'destroy')->name('destroy');
    });
});
