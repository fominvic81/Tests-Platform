<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestingController;
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
    
    Route::resource('course', CourseController::class)->except(['index', 'show', 'store', 'update', 'destroy']);

    Route::resource('test', TestController::class)->except(['index', 'show', 'store', 'update']);

    Route::get('/exam', [ExamController::class, 'index'])->name('exam.index');
    Route::resource('test.exam', ExamController::class)->shallow()->except(['index']);
});

Route::resource('course', CourseController::class)->only(['index', 'show']);
Route::resource('test', TestController::class)->only(['index', 'show']);

Route::get('/join', [ExamController::class, 'join'])->name('exam.join');
Route::post('/join', [ExamController::class, 'start'])->name('exam.start');

Route::get('/testing/{session}', [TestingController::class, 'show'])->name('testing.show');