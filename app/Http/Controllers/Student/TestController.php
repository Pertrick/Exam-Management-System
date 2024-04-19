<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Test;
use App\Models\Question;
use App\Models\TestType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject_ids = auth()->user()->subjects()->get()->pluck('id');
        $tests = Test::with(['subject', 'questions:question', 'testType'])

            ->whereIn('subject_id', $subject_ids)
            ->where('is_published', Test::PUBLISHED)
            ->where(function ($query) {
                $query->whereNull('start_date')
                      ->orWhereNull('end_date');
            })
            // ->where(function($query){
            //     $query->whereDoesntHave('users')
            //           ->orWhereHas('users', fn($q) => $q->where('status',0));
            // })
            ->orWhere(function ($query) {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
            })
            ->get()
            ->groupBy('testType.name');

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
        auth()->user()->tests()->attach(
            $request->test_id,
            [
                'start_time' => Carbon::now(),
                'status' => 1
            ]
        );

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
        $option_type = Question::OPTION;
        $multi_choice_type = Question::MULTI_CHOICE;
        $no_option = Question::NO_OPTION;
        $sn = 1;
        $test = Test::with(['questions.options.image', 'subject', 'questions.image'])->findOrFail($id);
        return view('student.test.show', compact('test', 'option_type', 'no_option', 'multi_choice_type', 'sn'));
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
        auth()->user()->tests()->updateExistingPivot(
            $request->test_id,
            [
                'end_time' => Carbon::now(),
            ]
        );

        return true;

      
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
