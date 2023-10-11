<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
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

Route::get('/', HomeController::class)->name('home');
Route::get('/home', HomeController::class);


Route::middleware('guest')->group(function () {
    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/registration', [RegistrationController::class, 'store']);
    
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'delete'])->name('logout');
    
    Route::resource('course', CourseController::class)->except(['index', 'show']);
    Route::resource('test', TestController::class)->except(['index', 'show']);
});
Route::resource('course', CourseController::class)->only(['index', 'show']);
Route::resource('test', TestController::class)->only(['index', 'show']);
