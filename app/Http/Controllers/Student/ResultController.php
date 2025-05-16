<?php

namespace App\Http\Controllers\Student;

use App\Models\Test;
use App\Models\Result;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Response;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Result::with([
            'testUser.test.subject',
            'testUser.test.testType',
            'testUser.user'
        ])
        ->whereHas('testUser', function($query) {
            $query->where('user_id', auth()->id());
        })
        ->latest()
        ->paginate(10);
        
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

        $result = Result::with(['testUser.test.subject:id,name', 
                              'testUser.test.questions.options.image', 
                              'testUser.test.questions.image',
                              'testUser.test.questions.responses' => function($query) use ($result_id) {
                                  $query->whereHas('testUser', function($q) use ($result_id) {
                                      $q->where('id', Result::find($result_id)->test_user_id);
                                  });
                              }])
                        ->whereHas('testUser', function($query) {
                            $query->where('user_id', auth()->id());
                        })
                        ->findOrFail($result_id);

        $test = $result->testUser->test;
        $testPivot = $result->testUser;

        $responses = Response::with(['question.options.image', 'question.image'])
            ->with(['question.options' => function ($query) {
                $query->where('is_correct', 1);
            }])
            ->where('test_user_id', $result->test_user_id)
            ->get();

        return view('student.result.show', compact('responses', 'result', 'test', 'testPivot', 'option_type', 'multi_choice_type', 'no_option'));
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
