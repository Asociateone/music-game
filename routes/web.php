<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/chat', [ChatController::class, 'index']);
Route::get('/messages', [ChatController::class, 'messages']);
Route::post('/messages', [ChatController::class, 'sendMessage']);
