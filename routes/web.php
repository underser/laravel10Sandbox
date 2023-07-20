<?php

use App\Http\Controllers\CustomersController;
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

    Route::get('/clients', function () {
        return view('crm.admin.clients.index');
    })->name('clients');

    Route::get('/projects', function () {
        return view('crm.admin.projects.index');
    })->name('projects');

    Route::get('/tasks', function () {
        return view('crm.admin.tasks.index');
    })->name('tasks');

});
