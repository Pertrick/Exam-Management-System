<?php

namespace App\Http\Controllers\Student;

use App\Models\Test;
use App\Models\Result;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = auth()->user()->results()->with(['test.subject','test.testType'])->latest()->get();
        return view('student.result.index', compact('results'));
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
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show($result_id)
    {
        $option_type = Question::OPTION;
        $multi_choice_type = Question::MULTI_CHOICE;
        $no_option = Question::NO_OPTION;

        $test = Test::with(['subject:id,name', 'questions.options.image','questions.image'])
                            ->with(['questions.responses' => function($q) use($result_id){
                                return $q->where('user_id', auth()->user()->id)->where('result_id', $result_id);
                            }])->whereHas('results', 
                                fn($q) => $q->where('id', $result_id)
                                ->where('user_id', auth()->user()->id))
                    ->first();

        $result = Result::findOrFail($result_id);

        $testPivot = $test->users()->first()->pivot;

        $responses = auth()->user()->responses()
                            ->with('question.options.image')
                            ->with(['question.options' => function($query){
                                $query->where('is_correct', 1);
        }])->with('question.image')->where('result_id', $result_id)->get();

        
        return view('student.result.show', compact('responses', 'result','test', 'testPivot', 'option_type','multi_choice_type', 'no_option'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request, Result $result)
    {
        
    }


       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
