<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::resource('items', \App\Http\Controllers\ItemController::class);
