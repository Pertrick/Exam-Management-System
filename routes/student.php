<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\TestController;
use App\Http\Controllers\Student\ResultController;
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


Route::group(['prefix' => 'student', 'middleware' => ['auth']],function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('student.dashboard');
    Route::get('/result', [ResultController::class, 'index'])->name('student.result.index');
    Route::get('/result-show', [ResultController::class, 'show'])->name('student.result.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('exam')->group(function(){
        Route::get('', [TestController::class, 'index'])->name('student.test.index');
        Route::get('/question/{id}', [TestController::class, 'question'])->name('student.test.questions');
        Route::get('create', [TestController::class, 'create'])->name('student.test.create');
        Route::get('/show/{id}', [TestController::class, 'show'])->name('student.test.show');
        Route::get('edit/{id}', [TestController::class, 'edit'])->name('student.test.edit');
        Route::post('store', [TestController::class, 'store'])->name('student.test.store');
        Route::put('update/{id}', [TestController::class, 'update'])->name('student.test.update');
        Route::delete('delete/{id}', [testController::class, 'destroy'])->name('student.test.delete');
    });
});