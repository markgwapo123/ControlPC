<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TargetPCController;


Route::get('/dashboard', [TargetPCController::class, 'dashboard']);