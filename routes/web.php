<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('crm.admin.dashboard');
    })->name('dashboard');

    Route::resource('customers', CustomersController::class)->parameters([
        'customers' => 'user'
    ]);
    Route::resource('clients', ClientsController::class);
    Route::resource('projects', ProjectsController::class);
    Route::resource('tasks', TasksController::class);
});
