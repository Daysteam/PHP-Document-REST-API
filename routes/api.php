<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/siswas', [SiswaController::class, 'index']);

Route::post('/siswas', [SiswaController::class, 'store']);

Route::get('/siswas/{id}', [SiswaController::class, 'show']);

Route::put('/siswas/{id}', [SiswaController::class, 'update']);

Route::patch('/siswas/{id}', [SiswaController::class, 'update']);

Route::delete('/siswas/{id}', [SiswaController::class, 'destroy']);