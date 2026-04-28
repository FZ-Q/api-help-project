<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('detail/{id}', function () {
    return view('detail');
});
