<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailController;
use App\Models\Email;
use App\Mail\BackgroundMail;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/send', [EmailController::class, 'send']);

//just for checking direct url if queue is working
Route::get('/test-queue', function () {
    dispatch(function () {
        \Log::info('Queue is working!');
    });
    return "Job queued!";
});

//this line we are using to check direct email on localhost
Route::get('/test-mail', function () {
    $email = Email::first();
    Mail::to($email->recipient)->send(new BackgroundMail($email));
    return "Mail sent directly!";
});