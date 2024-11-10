<?php

use App\Http\Controllers\Api\RepositoriesController;
use Illuminate\Support\Facades\Route;

Route::post('/repositories', [RepositoriesController::class, 'updateRepositories']);
Route::get('/repositories/{repository}', [RepositoriesController::class, 'showRepository']);
Route::post('/repositories/{repository}', [RepositoriesController::class, 'updateRepository']);
