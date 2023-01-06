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
        $passed_count = auth()->user()->results()->where('status',1)->count();
        $failed_count = auth()->user()->results()->where('status',0)->count();

        if(count(auth()->user()->subjects) == 0){
            $subjects = Subject::get(['id', 'name']);
            return view('student.dashboard', compact('passed_count', 'failed_count', 'subjects'));
        }
        return view('student.dashboard', compact('passed_count', 'failed_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * 
     */
    public function update()
    {
        //
    }

    
    public function destroy()
    {
        //
    }
}
