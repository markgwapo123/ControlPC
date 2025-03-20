<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TargetPCController;

Route::post('/add-pc', [TargetPCController::class, 'addPC']);
Route::get('/check-and-control', [TargetPCController::class, 'checkAndControl']);

