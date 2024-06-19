<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\Subject;
use App\Models\Question;
use App\Models\TestType;
use Illuminate\Http\Request;
use App\Exports\QuestionExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TestNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $value = $request->query('search');
        $tests = Test::search($value)->with(['subject', 'questions.options.image', 'questions.image','testType'])->latest()->paginate(10);
        return view('admin.test_new.index', compact('tests'));
    }

 
    public function question($id)
    {
        $questions = Question::with('options.image', 'image')->where('subject_id',$id)->get();
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
        $testTypes = TestType::get();
        return view('admin.test_new.create', compact('subjects','testTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'subject_id' => ['required'],
            'duration' => ['required'],
            'test_type' => ['required'],
            'instruction' => ['required','string'],
            'pass_mark' => ['required', 'string'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date'],
            'is_published' => ['required','in:0,1'],
        ]);

        $test = Test::create([
            'subject_id' => $request->subject_id,
            'duration' => $request->duration,
            'test_type_id' => $request->test_type,
            'instruction' => $request->instruction,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'pass_mark' => $request->pass_mark,
            'is_published' => $request->is_published
        ]);

        // $test->questions()->attach($request->question_ids);

        return redirect()->route('admin.test.new.index')->with('message', 'Question added to Exam successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        $option_type = Question::OPTION;
        $multi_choice_type = Question::MULTI_CHOICE;
        $no_option = Question::NO_OPTION;
        $test->load(['questions.options.image', 'subject', 'questions.image']);
        // dd($test);
        return view('admin.test_new.questions', compact('test', 'option_type', 'no_option', 'multi_choice_type'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test = Test::with(['subject','testType'])->findOrFail($id);
        $test_subject_id = $test->subject_id;
        $test_question_ids = $test->questions->pluck('id');
        $testTypes = TestType::get();
        $subjects = subject::all();
        $questions = Question::with('options.image', 'image')->where('subject_id', $test_subject_id)->whereNotIn('id',$test_question_ids)->get();
        
        return view('admin.test_new.edit', compact('test', 'questions','testTypes','subjects'));
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
        $test->pass_mark =  $request->pass_mark ?? $test->pass_mark;
        $test->test_type_id = $request->test_type_id ?? $test->test_type_id;
        $test->instruction = $request->instruction ?? $test->instruction;
        $test->start_date = $request->start_date ?? $test->start_date;
        $test->end_date = $request->end_date ?? $test->end_date;
        $test->is_published = $request->is_published ?? $test->is_published;
        $test->save();

        return redirect()->route('admin.test.new.index')->with('message', 'Exam updated successfully!');

    }


      /**
     * Publish the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $test = Test::findOrFail($id);
        if($test->is_published){
        $test->is_published = Test::UNPUBLISHED;
            $test->save();
            return false;
        }else{
            $test->is_published = Test::PUBLISHED;
            $test->save();
            return true;
        }

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

        if($test->users()->detach()){
            $test->delete();
        }
        
        return redirect()->back()->with('message', 'Test Deleted Successfully!');
    }


    public function export($id){
        $test = Test::with(['questions.options.image','subject', 'questions.image'])->findOrFail($id);
        $subjectName = $test->subject->name;
        $test_question_ids = $test->questions->pluck('id');
        $questions = Question::with('options.image', 'image')->where('subject_id', $test->subject_id)->whereNotIn('id',$test_question_ids)->get();
        
        $option_type = Question::OPTION;
        $multi_choice_type = Question::MULTI_CHOICE;
        $no_option = Question::NO_OPTION;

        $pdf = Pdf::loadView('admin.test.export', compact('test','questions','option_type','multi_choice_type','no_option'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->download("$subjectName test.pdf");
    }
}
