<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\TestController;
use App\Models\Grade;
use App\Models\Subject;
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

    Route::apiResource('course', CourseController::class)->only(['index', 'show']);
    Route::apiResource('test', TestController::class)->only(['index', 'show', 'update']);
    Route::apiResource('question', QuestionController::class)->except(['index']);

    Route::get('/test-options', function (Request $request) {
        return response()->json([
            'courses' => $request->user()->courses->toArray(),
            'subjects' => Subject::all()->toArray(),
            'grades' => Grade::all()->toArray(),
        ]);
    });

});