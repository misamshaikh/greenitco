<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/emails', [EmailController::class, 'index']);
Route::get('/emails/{id}', [EmailController::class, 'show']);
Route::post('/emails', [EmailController::class, 'store']);