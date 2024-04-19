<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\TestController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Student\ResponseController;
use App\Http\Controllers\Student\SubjectController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\ExamAuthController;
use App\Http\Controllers\Student\ResourcesController;
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


Route::group(['prefix' => 'student', 'middleware' => ['auth','subject']],function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('student.dashboard');
    Route::get('/result', [ResultController::class, 'index'])->name('student.result.index');
    Route::get('/result-show/{id}', [ResultController::class, 'show'])->name('student.result.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('subject')->group(function(){
        Route::get('', [SubjectController::class, 'index'])->name('student.subject.index');
        Route::delete('delete/{id}', [SubjectController::class, 'destroy'])->name('student.subject.delete');
    });


    Route::group(['prefix' => 'exam', 'middleware' => ['exam']],function(){
        Route::get('', [TestController::class, 'index'])->name('student.test.index');
        Route::get('/question/{id}', [TestController::class, 'question'])->name('student.test.questions');
        Route::get('create', [TestController::class, 'create'])->name('student.test.create');
        Route::get('/show/{id}', [TestController::class, 'show'])->name('student.test.show');
        Route::get('edit/{id}', [TestController::class, 'edit'])->name('student.test.edit');
        Route::post('store', [TestController::class, 'store'])->name('student.test.store');
        Route::post('update/{id}', [TestController::class, 'update'])->name('student.test.update');
        Route::delete('delete/{id}', [testController::class, 'destroy'])->name('student.test.delete');
    });

    Route::prefix('response')->group(function(){
        Route::get('', [ResponseController::class, 'index'])->name('student.response.index');
        Route::get('/question/{id}', [ResponseController::class, 'question'])->name('student.response.questions');
        Route::get('create', [ResponseController::class, 'create'])->name('student.response.create');
        Route::get('/show/{id}', [ResponseController::class, 'show'])->name('student.response.show');
        Route::get('edit/{id}', [ResponseController::class, 'edit'])->name('student.response.edit');
        Route::post('store', [ResponseController::class, 'store'])->name('student.response.store');
        Route::put('update/{id}', [ResponseController::class, 'update'])->name('student.response.update');
        Route::delete('delete/{id}', [ResponseController::class, 'destroy'])->name('student.response.delete');
    });

    Route::prefix('payment')->group(function(){
        Route::get('', [PaymentController::class, 'index'])->name('student.payment.index');
        Route::post('pay', [PaymentController::class, 'store'])->name('student.payment.store');
    });

    Route::prefix('exam-auth')->group(function(){
        Route::get('', [ExamAuthController::class, 'index'])->name('student.exam.auth.index');
        Route::post('store', [ExamAuthController::class, 'store'])->name('student.exam.auth.store');
    });

    Route::prefix('resources')->group(function(){
        Route::get('', [ResourcesController::class, 'index'])->name('student.resources.index');
    });

});

Route::group(['prefix' => 'student/subject', 'middleware' => ['auth']],function () {
    Route::get('select', [SubjectController::class, 'create'])->name('student.subject.create');
    Route::post('/store', [SubjectController::class, 'store'])->name('student.subject.store');
});

