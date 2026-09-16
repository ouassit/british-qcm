<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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
    $center = User::find($id);
    $logoUrl = $center ? $center->logo_url : asset('images/logos/default-logo.png');

    return view('test', ['id' => $id, 'logoUrl' => $logoUrl]);
});

Route::middleware([
    'auth',
])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin/centers/{center}/renew', [App\Http\Controllers\DashboardController::class, 'renewCenter'])->name('admin.centers.renew');
    Route::post('/admin/centers/{center}/password', [App\Http\Controllers\DashboardController::class, 'updateCenterPassword'])->name('admin.centers.password');
    Route::get('/admin/centers', [App\Http\Controllers\AdminCenterController::class, 'index'])->name('admin.centers.index');
    Route::get('/admin/centers/create', [App\Http\Controllers\AdminCenterController::class, 'create'])->name('admin.centers.create');
    Route::post('/admin/centers', [App\Http\Controllers\AdminCenterController::class, 'store'])->name('admin.centers.store');
    Route::post('/admin/centers/{center}/reset-password', [App\Http\Controllers\AdminCenterController::class, 'resetPassword'])->name('admin.centers.reset-password');
    Route::get('/admin/test-import', [App\Http\Controllers\TestImportController::class, 'index'])->name('admin.test-import.index');
    Route::get('/admin/test-import/centers/{center}/tests', [App\Http\Controllers\TestImportController::class, 'sourceTests'])->name('admin.test-import.tests');
    Route::post('/admin/test-import', [App\Http\Controllers\TestImportController::class, 'import'])->name('admin.test-import.store');

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
