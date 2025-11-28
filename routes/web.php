<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('index'); // This will load resources from public/index.html
})->where('any', '.*');