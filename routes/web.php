<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::middleware([
    'auth',
])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', \App\Http\Controllers\CategorieController::class);
    Route::resource('tests', \App\Http\Controllers\TestController::class);
    Route::resource('questions', \App\Http\Controllers\QuestionController::class);
    
    Route::resource('students_tests', \App\Http\Controllers\StudentTestController::class)->only(
        ['index', 'create', 'store', 'destroy', 'show', 'update', 'print']
    );
    Route::get('students_tests/print/{student_test_id}/{correction}', '\App\Http\Controllers\StudentTestController@print')->name('students_tests.print');

    Route::resource('settings', \App\Http\Controllers\SettingsController::class);



});

Auth::routes();
