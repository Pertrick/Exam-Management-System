<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passed_count = auth()->user()->passedResults()->count();
        $failed_count = auth()->user()->failedResults()->count();

        return view('student.dashboard', compact('passed_count', 'failed_count'));
    }


   
}
