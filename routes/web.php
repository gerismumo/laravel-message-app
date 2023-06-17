<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
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



//index page
Route::get('/index',[IndexController::class, 'index']) -> name('index');

//registration page
Route::get('/register',[RegisterController::class, 'index']) -> name('register');
Route::post('/register',[RegisterController::class, 'store']);

//login page
Route::get('/login',[LoginController::class, 'index']) -> name('login');
Route::post('/login',[LoginController::class, 'store']);

//logout page
Route::get('/logout',[LogoutController::class, 'index']) -> name('logout');
Route::post('/logout',[LogoutController::class, 'logout']);

//admin page
Route::get('/admin',[AdminController::class, 'index']) -> name('admin');
Route::post('/admin',[AdminController::class, 'store']);

//dashboard page
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
// /messages/send
// Route for sending a message
Route::post('/dashboard', [DashboardController::class, 'sendMessage'])->middleware('auth')->name('dashboard');

// Route for deleting a message
Route::delete('/messages/delete/{messageId}', [DashboardController::class, 'deleteMessage'])->middleware('auth')->name('messages.delete');

Route::get('/messages/fetch/{userId}', [DashboardController::class, 'fetchMessages'])->name('messages.fetch');


Route::get('/', function () {
    return view('contents.welcome');
});