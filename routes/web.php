<?php

use App\Http\Controllers\SharkController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::resource('sharks', SharkController::class);
