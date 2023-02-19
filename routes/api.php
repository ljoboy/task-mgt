<?php

use App\Http\Controllers\API\V1\ProjectAPIController;
use App\Http\Controllers\API\V1\TaskAPIController;
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
    Route::apiResource('projects', ProjectAPIController::class);
    Route::apiResource('projects.tasks', TaskAPIController::class);
});
