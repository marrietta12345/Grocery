<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Basic API routes (note: registration controller removed until implemented)
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// You can add additional API endpoints here once the corresponding
// controllers exist.  The welcome view is typically served by web routes
// so a GET '/' route isn’t needed in this file.

