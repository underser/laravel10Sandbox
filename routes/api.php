<?php

use App\Http\Controllers\Api\V1\Async\BulkDetailedStatus;
use App\Http\Controllers\Api\V1\Async\ProjectsBulkController;
use App\Http\Controllers\Api\V1\Async\TasksBulkController;
use App\Http\Controllers\Api\V1\ClientsController;
use App\Http\Controllers\Api\V1\CustomersController;
use App\Http\Controllers\Api\V1\ProjectsController;
use App\Http\Controllers\Api\V1\SearchSuggestions;
use App\Http\Controllers\Api\V1\TasksController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1', 'as' => 'api.'], function () {

    // CRUD.
    Route::apiResource('customers', CustomersController::class)
        ->parameters(['customers' => 'user'])
        ->only(['index', 'show', 'destroy']);
    Route::apiResource('clients', ClientsController::class)
        ->parameters(['clients' => 'user'])
        ->only(['index', 'show', 'destroy']);
    Route::apiResource('projects', ProjectsController::class);
    Route::apiResource('tasks', TasksController::class);

    // Search.
    Route::get('search/suggestions', SearchSuggestions::class);

    // Async bulk.
    Route::post('async/bulk/projects', ProjectsBulkController::class)->name('async.bulk.projects');
    Route::post('async/bulk/tasks', TasksBulkController::class)->name('async.bulk.tasks');
    Route::get('async/bulk/{bulkId}/detailed-status', BulkDetailedStatus::class)
        ->name('async.bulk.detailed-status');
});
