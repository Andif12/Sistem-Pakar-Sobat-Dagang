<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekomendasiController;

Route::post('/kirim-ke-python', [RekomendasiController::class, 'kirimKePython']);
