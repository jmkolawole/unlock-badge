<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{id}/achievements', [AchievementsController::class, 'index']);
//Route::get('users/{user}/achievements', [AchievementsController::class, 'index']);
