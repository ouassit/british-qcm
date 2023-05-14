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
    Route::resource('quizs', \App\Http\Controllers\TestController::class);
    Route::resource('questions', \App\Http\Controllers\QuestionController::class);
    
    Route::resource('students_tests', \App\Http\Controllers\StudentTestController::class)->only(
        ['index', 'create', 'store', 'storemultiple', 'destroy', 'show', 'update', 'print']
    );
    Route::get('students_tests/print/{student_test_id}/{correction}', '\App\Http\Controllers\StudentTestController@print')->name('students_tests.print');
    Route::post('students_tests/storemultiple', '\App\Http\Controllers\StudentTestController@storeMultiple')->name('students_tests.storemultiple');

    Route::resource('settings', \App\Http\Controllers\SettingsController::class);

    Route::get('/change-password', [App\Http\Controllers\SettingsController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('update-password');

});

Route::get('login', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', '\App\Http\Controllers\Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', '\App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', '\App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset');