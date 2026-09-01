<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Exports\StudentTestExport;
use Maatwebsite\Excel\Facades\Excel;

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

Route::get('/new-center', [App\Http\Controllers\NewCenterController::class, 'copy'])->name('new-center');

Route::get('/', function () {
    return view('index');
});

Route::get('/test/{id?}', function ($id = 0) {
    return view('test', ['id' => $id]);
});

Route::middleware([
    'auth',
])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin/centers/{center}/renew', [App\Http\Controllers\DashboardController::class, 'renewCenter'])->name('admin.centers.renew');
    Route::post('/admin/centers/{center}/password', [App\Http\Controllers\DashboardController::class, 'updateCenterPassword'])->name('admin.centers.password');

    Route::resource('categories', \App\Http\Controllers\CategorieController::class);
    Route::resource('quizs', \App\Http\Controllers\TestController::class);
    Route::resource('tests', \App\Http\Controllers\TestController::class);
    Route::resource('questions', \App\Http\Controllers\QuestionController::class);
    
    Route::get('students_tests/print/{student_test_id}/{correction}', '\App\Http\Controllers\StudentTestController@print')->name('students_tests.print');
    Route::get('students_tests/export', function () {
        return Excel::download(new StudentTestExport, 'users.xlsx');
    })->name('students_tests.export');

    Route::get('students_tests/export/{student_test_id}', '\App\Http\Controllers\StudentTestController@export')->name('students_tests.export');
    Route::post('students_tests/storemultiple', '\App\Http\Controllers\StudentTestController@storeMultiple')->name('students_tests.storemultiple');
    Route::resource('students_tests', \App\Http\Controllers\StudentTestController::class)->only(
        ['index', 'create', 'store', 'storemultiple', 'destroy', 'show', 'update', 'print']
    );
    

    Route::resource('settings', \App\Http\Controllers\SettingsController::class);

    Route::get('/change-password', [App\Http\Controllers\SettingsController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('update-password');

});

Auth::routes();
