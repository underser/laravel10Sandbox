<?php

use App\Http\Controllers\Api\V1\ClientsController;
use App\Http\Controllers\Api\V1\CustomersController;
use App\Http\Controllers\Api\V1\ProjectsController;
use App\Http\Controllers\Api\V1\SearchSuggestions;
use App\Http\Controllers\Api\V1\TasksController;
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

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1', 'as' => 'api.'], function () {
    Route::apiResource('customers', CustomersController::class)->parameters([
        'customers' => 'user'
    ])->only(['index', 'show', 'destroy']);
    Route::apiResource('clients', ClientsController::class);
    Route::apiResource('projects', ProjectsController::class);
    Route::apiResource('tasks', TasksController::class);

    Route::get('search/suggestions', SearchSuggestions::class);
});
