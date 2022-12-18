<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\Subject;
use App\Models\Option;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionFormRequest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with(['options', 'subject'])->get();
        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        $question_types = Question::TYPES;
        return view('admin.question.create', compact('subjects', 'question_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionFormRequest $request)
    {
        $request->validated();

        $question =  Question::create([
            'question' => $request->question,
            'subject_id' => $request->subject_id,
            'type' => $request->type,
            'point' => $request->point,
        ]);

        foreach ($request->option as $key =>  $opt) {
            $option = new Option();
            $option->question_id = $question->id;
            $option->label = $opt;

            foreach ($request->is_correct as $is_correct_key => $is_correct) {
                if ($is_correct_key == $key) {
                    $option->is_correct = $is_correct;
                }
                $option->save();
            }
        };

        return redirect()->route('admin.question.index')->with('message', 'Question created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::all();
        $question_types = Question::TYPES;
        $question = Question::with('options', 'subject')->findOrFail($id);

        return view('admin.question.edit', compact('subjects', 'question_types', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quest = Question::with('options')->findOrFail($id);

        $quest->question = $request->question ?? $quest->question;
        $quest->type = $request->type ?? $quest->type;
        $quest->point = $request->point ?? $quest->point;
        $quest->save();

        $retrievedOptions = $quest->options;

        foreach ($retrievedOptions as $retrieved_key => $retrievedOption) {
            foreach ($request->option as $key =>  $opt) {
                if ($retrieved_key == $key) {
                    $retrievedOption->label = $opt;
                }
                foreach ($request->is_correct as $is_correct_key => $is_correct) {
                    if ($is_correct_key == $retrieved_key && $is_correct_key == $key) {
                        $retrievedOption->is_correct = $is_correct;
                    }
                }
                $retrievedOption->save();
            };
        };

        return redirect()->route('admin.question.index')->with('message', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->route('admin.question.index')->with('message', 'Question deleted successfully!');
    }
}
