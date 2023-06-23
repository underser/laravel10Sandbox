<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::post('posts', [\App\Http\Controllers\PostController::class, 'store']);
Route::post('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->middleware('auth');
Route::resource('projects', \App\Http\Controllers\ProjectController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::resource('teams', \App\Http\Controllers\TeamController::class);
Route::resource('items', \App\Http\Controllers\ItemController::class);
Route::put('users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
Route::resource('buildings', \App\Http\Controllers\BuildingController::class);
Route::resource('articles', \App\Http\Controllers\ArticleController::class);
