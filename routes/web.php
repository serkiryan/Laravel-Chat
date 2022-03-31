<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChatMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/messages', [App\Http\Controllers\HomeController::class, 'getMessages'])->name('messages');
Route::get('/users', [App\Http\Controllers\HomeController::class, 'getUsers'])->name('users');

Route::post('/messages/{id}', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('sendMessage');