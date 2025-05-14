<?php

use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

Route::get('logs/getone',[LogController::class,'getRecordForPrediction']);
Route::post('logs/result',[LogController::class,'submitPrediction']);
