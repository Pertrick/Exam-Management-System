<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Test;
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
        $test_count = auth()->user()->tests()->count();
        $passed_count = auth()->user()->results()->where('status',1)->count();
        $failed_count = auth()->user()->results()->where('status',0)->count();
        return view('student.dashboard', compact('test_count', 'passed_count', 'failed_count'));
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
