<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::with(['subject', 'questions.options'])->get();
        return view('admin.test.index', compact('tests'));
    }

 
    public function question($id)
    {
        $questions = Question::with('options')->where('subject_id',$id)->get();
        return $questions; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $subjects = subject::all();
        return view('admin.test.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $test = Test::create([
            'subject_id' => $request->subject_id,
            'duration' => $request->duration,
        ]);

        $test->questions()->attach($request->question_ids);

        return redirect()->route('admin.test.index')->with('message', 'Question added to Exam successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test = Test::with(['questions.options','subject'])->findOrFail($id);
        $test_subject_id = $test->subject_id;
        $test_question_ids = $test->questions->pluck('id');
        $questions = Question::where('subject_id', $test_subject_id)->whereNotIn('id',$test_question_ids)->get();
        
        return view('admin.test.edit', compact('test', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $test->duration =  $request->duration ?? $test->duration;
        $test->save();

        $test->questions()->sync($request->question_ids);

        return redirect()->route('admin.test.index')->with('message', 'Questions updated to Exam successfully!');

    }


      /**
     * Publish the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request,$id)
    {
        dd($request->all());
        $test = Test::findOrFail($id);
        $test->is_published =  $request->is_published ?? $test->is_published;
        $test->save();

        return redirect()->route('admin.test.index')->with('message', 'Question published successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();

        return redirect()->back()->with('message', 'Test Deleted Successfully!');
    }
}
