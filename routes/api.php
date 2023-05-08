<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {
    Route::get('students_tests/access_code/{access_code}', '\App\Http\Controllers\StudentTestController@findByAccessCode');
    Route::put('students_tests/{student_test_id}', '\App\Http\Controllers\StudentTestController@apiUpdate');
    Route::get('students_tests/{student_test_id}', '\App\Http\Controllers\StudentTestController@apiShow');
    Route::post('students_tests/answer', '\App\Http\Controllers\StudentTestController@answer');
    Route::post('students_tests/time', '\App\Http\Controllers\StudentTestController@time');
    Route::post('students_tests/finish', '\App\Http\Controllers\StudentTestController@finish');
});


