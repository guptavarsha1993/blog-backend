<?php


use App\Http\Controllers\API\RegisterController;


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);








