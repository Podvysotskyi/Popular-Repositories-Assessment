<?php

use App\Http\Controllers\RepositoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/repositories/{repository}', [RepositoriesController::class, 'show']);
