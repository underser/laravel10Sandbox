<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// NOTICE: Not all the routes are logical and would exist in a real Laravel project
// Some routes are just for the purpose of replicating some testing scenario

Route::get('users', [UserController::class, 'index']);
Route::get('users/active', [UserController::class, 'only_active']);
Route::get('users/{userId}', [UserController::class, 'show']);
Route::get('users/check/{name}/{email}', [UserController::class, 'check_create']);
Route::get('users/check_update/{name}/{email}', [UserController::class, 'check_update']);
Route::delete('users', [UserController::class, 'destroy']);

Route::post('projects', [ProjectController::class, 'store']);
Route::post('projects/stats', [ProjectController::class, 'store_with_stats']);
Route::post('projects/mass_update', [ProjectController::class, 'mass_update']);
Route::delete('projects/{projectId}', [ProjectController::class, 'destroy']);
