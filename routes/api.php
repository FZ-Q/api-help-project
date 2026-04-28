<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;

Route::apiResource('trains', TrainController::class);
