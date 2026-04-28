<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;

Route::apiResource('train', TrainController::class);
