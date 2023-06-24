<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::post('projects', [\App\Http\Controllers\ProjectController::class, 'store']);

Route::get('houses/download/{house}', [\App\Http\Controllers\HouseController::class, 'download']);
Route::resource('houses', \App\Http\Controllers\HouseController::class);

Route::resource('offices', \App\Http\Controllers\OfficeController::class);

Route::post('shops', [\App\Http\Controllers\ShopController::class, 'store']);

Route::resource('companies', \App\Http\Controllers\CompanyController::class);
