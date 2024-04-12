<?php

use App\Models\Test;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Api\RegisteredUserController;

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


Route::post('auth/register', [RegisteredUserController::class, 'store'])->name('auth.register');


Route::get('courses/programs/{program}', function($programId){
    return Course::whereHas('programs', fn($q) => $q->where('program_id', $programId))->get();
});

Route::get('exams', function(){
    return Test::with(['results', 'subject'])->Has('results')->get();
});