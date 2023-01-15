<?php

use App\Http\Controllers\Admin\AccessPinController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TestController;
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


Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    Route::get('', [HomeController::class, 'index'])->name('admin.dashboard.index');
    Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::prefix('subject')->group(function(){
        Route::get('', [SubjectController::class, 'index'])->name('admin.subject.index');
        Route::post('store', [SubjectController::class, 'store'])->name('admin.subject.store');
        Route::delete('delete/{id}', [SubjectController::class, 'destroy'])->name('admin.subject.delete');
    });

    Route::prefix('question')->group(function(){
        Route::get('', [QuestionController::class, 'index'])->name('admin.question.index');
        Route::get('create', [QuestionController::class, 'create'])->name('admin.question.create');
        Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('admin.question.edit');
        Route::post('store', [QuestionController::class, 'store'])->name('admin.question.store');
        Route::put('update/{id}', [QuestionController::class, 'update'])->name('admin.question.update');
        Route::delete('delete/{id}', [QuestionController::class, 'destroy'])->name('admin.question.delete');
    });

    Route::prefix('student')->group(function(){
        Route::get('', [StudentController::class, 'index'])->name('admin.student.index');
        Route::get('create', [StudentController::class, 'create'])->name('admin.student.create');
        Route::get('edit', [StudentController::class, 'edit'])->name('admin.student.edit');
        Route::post('store', [StudentController::class, 'store'])->name('admin.student.store');
        Route::put('update', [StudentController::class, 'update'])->name('admin.student.update');
        Route::delete('delete/{id}', [StudentController::class, 'destroy'])->name('admin.student.delete');
    });

    Route::prefix('exam')->group(function(){
        Route::get('', [TestController::class, 'index'])->name('admin.test.index');
        Route::get('/question/{id}', [TestController::class, 'question'])->name('admin.test.questions');
        Route::get('create', [TestController::class, 'create'])->name('admin.test.create');
        Route::get('edit/{id}', [TestController::class, 'edit'])->name('admin.test.edit');
        Route::post('store', [TestController::class, 'store'])->name('admin.test.store');
        Route::put('update/{id}', [TestController::class, 'update'])->name('admin.test.update');
        Route::get('publish/{id}', [TestController::class, 'publish'])->name('admin.test.publish');
        Route::delete('delete/{id}', [testController::class, 'destroy'])->name('admin.test.delete');
    });

    Route::prefix('accesspin')->group(function(){
        Route::get('', [AccessPinController::class, 'index'])->name('admin.accesspin.index');
        Route::get('/generate', [AccessPinController::class, 'create'])->name('admin.accesspin.create');
    });

});
