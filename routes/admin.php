<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AccessPinController;
use App\Http\Controllers\Admin\ResourcesController;
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


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard.index');
    Route::prefix('subject')->group(function () {
        Route::get('', [SubjectController::class, 'index'])->name('admin.subject.index');
        Route::get('{subject}', [SubjectController::class, 'show'])->name('admin.subject.show');
        Route::post('store', [SubjectController::class, 'store'])->name('admin.subject.store');
        Route::delete('/student/delete/{id}', [SubjectController::class, 'detach'])->name('admin.student.subject.delete');
        Route::delete('delete/{id}', [SubjectController::class, 'destroy'])->name('admin.subject.delete');
       
    });

    Route::prefix('question')->group(function () {
        Route::get('', [QuestionController::class, 'index'])->name('admin.question.index');
        Route::get('create', [QuestionController::class, 'create'])->name('admin.question.create');
        Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('admin.question.edit');
        Route::post('store', [QuestionController::class, 'store'])->name('admin.question.store');
        Route::put('update/{id}', [QuestionController::class, 'update'])->name('admin.question.update');
        Route::delete('delete/{id}', [QuestionController::class, 'destroy'])->name('admin.question.delete');
        Route::get('import', [QuestionController::class, 'import'])->name('admin.question.import');
        Route::post('upload', [QuestionController::class, 'uploadExcel'])->name('admin.question.upload-excel');
    });

    Route::prefix('student')->group(function () {
        Route::get('', [StudentController::class, 'index'])->name('admin.student.index');
        Route::get('create', [StudentController::class, 'create'])->name('admin.student.create');
        Route::get('edit', [StudentController::class, 'edit'])->name('admin.student.edit');
        Route::post('store', [StudentController::class, 'store'])->name('admin.student.store');
        Route::put('update', [StudentController::class, 'update'])->name('admin.student.update');
        Route::delete('delete/{id}', [StudentController::class, 'destroy'])->name('admin.student.delete');
    });

    Route::prefix('exam')->group(function () {
        Route::get('', [TestController::class, 'index'])->name('admin.test.index');
        Route::get('/question/{id}', [TestController::class, 'question'])->name('admin.test.questions');
        Route::get('create', [TestController::class, 'create'])->name('admin.test.create');
        Route::get('edit/{id}', [TestController::class, 'edit'])->name('admin.test.edit');
        Route::post('store', [TestController::class, 'store'])->name('admin.test.store');
        Route::put('update/{id}', [TestController::class, 'update'])->name('admin.test.update');
        Route::get('publish/{id}', [TestController::class, 'publish'])->name('admin.test.publish');
        Route::delete('delete/{id}', [testController::class, 'destroy'])->name('admin.test.delete');
        Route::post('export/{id}', [testController::class, 'export'])->name('admin.test.export');
    });

    Route::prefix('accesspin')->group(function () {
        Route::get('', [AccessPinController::class, 'index'])->name('admin.accesspin.index');
        Route::get('/generate', [AccessPinController::class, 'create'])->name('admin.accesspin.create');
    });

    Route::prefix('resources')->group(function () {
        Route::get('', [ResourcesController::class, 'index'])->name('admin.resources.index');
        Route::post('store', [ResourcesController::class, 'store'])->name('admin.resources.store');
    });



    Route::resource('programs', ProgramController::class)
        ->name('index', 'admin.program.index')
        ->name('store', 'admin.program.store')
        ->name('destroy', 'admin.program.delete');


    Route::resource('courses', CourseController::class)
        ->name('index', 'admin.course.index')
        ->name('store', 'admin.course.store')
        ->name('destroy', 'admin.course.delete');

    Route::resource('results', ResultController::class)
        ->name('index', 'admin.result.index')
        ->name('show', 'admin.result.show')
        ->name('store', 'admin.result.store')
        ->name('destroy', 'admin.result.delete');

    Route::resource('settings', SettingsController::class)
        ->name('index', 'admin.settings.index')
        ->name('store', 'admin.settings.store')
        ->name('destroy', 'admin.settings.delete');
});
