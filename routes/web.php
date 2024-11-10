<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\RepositoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', RepositoriesController::class)->name('repositories');
Route::get('/about', AboutController::class)->name('about');
