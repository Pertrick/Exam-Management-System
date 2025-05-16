<?php

use App\Models\Role;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TestNewController;

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
    $settings = Setting::first() ?? new Setting();
    return view('welcome', compact('settings'));
});

Route::get('/dashboard', function () {
    if(auth()->user()->role_id == Role::ADMIN){
       return redirect()->route('admin.dashboard.index');
    }

    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/tests/archive', [TestNewController::class, 'archive'])->name('tests.archive');
    Route::post('/tests/unarchive', [TestNewController::class, 'unarchive'])->name('tests.unarchive');
});

require __DIR__.'/auth.php';
require __DIR__.'/student.php';
require __DIR__.'/admin.php';