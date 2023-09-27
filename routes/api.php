<?php

use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/token', function (Request $request) {
        return $request->user()->createToken('token')->plainTextToken;
    });

    Route::apiResource('test', TestController::class)->except(['index', 'store']);
    Route::apiResource('question', QuestionController::class)->except(['index']);

});