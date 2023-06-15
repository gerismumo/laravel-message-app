<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('contents.welcome');
});

//index page
Route::get('/index',[IndexController::class, 'index']) -> name('index');

//registration page
Route::get('register',[RegisterController::class, 'index']) -> name('register');

//login page
Route::get('login',[LoginController::class, 'index']) -> name('login');
