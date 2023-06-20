<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('tasks', [TaskController::class, 'index']);
Route::post('tasks', [TaskController::class, 'store'])->middleware('auth');

Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
Route::get('users/{user}', [\App\Http\Controllers\UserController::class, 'show']);

Route::get('roles', [\App\Http\Controllers\RoleController::class, 'index']);

Route::get('teams', [\App\Http\Controllers\TeamController::class, 'index']);

Route::get('countries', [\App\Http\Controllers\CountryController::class, 'index']);

Route::get('attachments', [\App\Http\Controllers\AttachmentController::class, 'index']);

Route::post('projects', [\App\Http\Controllers\ProjectController::class, 'store'])->middleware('auth');
