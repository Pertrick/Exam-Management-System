<?php

namespace App\Http\Controllers\Student;

use App\Models\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Carbon\Carbon;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::with(['subject', 'questions:question'])->where('is_published',Test::PUBLISHED)->get();
        return view('student.test.index', compact('tests'));
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
        auth()->user()->tests()->attach($request->test_id, 
        [
            'start_time' => Carbon::now(), 
            'end_time' => Carbon::now()->addSecond($request->duration)
        ]);
        
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option_type= Question::OPTION;
        $multi_choice_type = Question::MULTI_CHOICE;
        $sn =1;
        $test = Test::with(['questions.options','subject'])->findOrFail($id);
        return view('student.test.show', compact('test', 'option_type', 'multi_choice_type', 'sn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
