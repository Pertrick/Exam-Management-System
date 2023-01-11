<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\Subject;
use App\Models\Option;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionFormRequest;
use App\Services\ImageService;
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
        $questions = Question::with(['options.image', 'subject', 'image'])->get();
        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all(['id', 'name']);
        $question_types = Question::TYPES;
        return view('admin.question.create', compact('subjects', 'question_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImageService $imageService)
    {
        // dd($request->all());
        // $request->validated();

        $question =  Question::create([
            'question' => $request->question,
            'subject_id' => $request->subject_id,
            'type' => $request->type,
            'point' => $request->point,
        ]);

        if (!is_null($request->question_image)) {
            $imageService->storeQuestionImage($question, $request->question_image);
        }

        foreach ($request->option as $key =>  $opt) {
            $option = new Option();
            $option->question_id = $question->id;
            $option->label = $opt;

            if($request->type == 'option'){

                if($request->is_correct == $key){
                    $option->is_correct = "on";
                }
                $option->save();
            }else if($request->type == 'multiple-choice'){

                foreach ($request->is_correct as $is_correct_key => $is_correct) {
                    if ($is_correct_key == $key) {
                        $option->is_correct = $is_correct;
                    }
                    $option->save();
                }
            }else if($request->type == 'no-option'){
                $option->is_correct = "on";
                $option->save();
            }
               
        if (!is_null($request->option_image)) {
            if (!empty(array_filter($request->option_image))) {
                foreach (array_filter($request->option_image) as $opt_key =>  $opt_image) {
                    if ($opt_key == $key) {
                        if (!is_null($opt_image)) {
                            $imageService->storeOptionImage($option, $opt_image);
                        }
                    }
                };
            }
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
        $subjects = Subject::select('name');
        $question_types = Question::TYPES;
        $question = Question::with('image', 'options.image', 'subject')->findOrFail($id);

        return view('admin.question.edit', compact('subjects', 'question_types', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageService $imageService, $id)
    {

        $quest = Question::with('options.image', 'image')->findOrFail($id);

        $quest->question = $request->question ?? $quest->question;
        $quest->type = $request->type ?? $quest->type;
        $quest->point = $request->point ?? $quest->point;
        $quest->save();

        $retrievedOptions = $quest->options;

        if (!is_null($request->question_image)) {
            $imageService->updateQuestionImage($quest, $request->question_image);
        }
        
        foreach ($retrievedOptions as $retrieved_key => $retrievedOption) {
            foreach ($request->option as $key =>  $opt) {
                if ($retrieved_key == $key) {
                    $retrievedOption->label = $opt;
                    $retrievedOption->save();
                }

                if($request->type == 'option'){
                    if($request->is_correct == $retrieved_key){
                        $retrievedOption->is_correct = "on";
                    }else{
                        $retrievedOption->is_correct = "off";
                    }
                    $retrievedOption->save();
                }
                else if($request->type == 'multiple-choice'){
                    foreach ($request->is_correct as $is_correct_key => $is_correct) {
                        if ($is_correct_key == $retrieved_key && $is_correct_key == $key) {
                            $retrievedOption->is_correct = $is_correct;
                        }
                    }
                    $retrievedOption->save();
                }
              
                if (!is_null($request->option_image)) {
                    if (!empty(array_filter($request->option_image))) {
                        foreach (array_filter($request->option_image) as $opt_key =>  $opt_image) {
                            if ($opt_key == $retrieved_key  && $opt_key  == $key) {
                                if (!is_null($opt_image)) {
                                    $imageService->updateOptionImage($retrievedOption, $opt_image);
                                }
                            }
                        }
                    }
                }
            }
        };

        // foreach ($retrievedOptions as $retrieved_key => $retrievedOption) {
        //     foreach ($request->option as $key =>  $opt) {
        //         if ($retrieved_key == $key) {
        //             $retrievedOption->label = $opt;
        //         }
        //         foreach ($request->is_correct as $is_correct_key => $is_correct) {
        //             if ($is_correct_key == $retrieved_key && $is_correct_key == $key) {
        //                 $retrievedOption->is_correct = $is_correct;
        //             }
        //         }
        //         $retrievedOption->save();
        //     };
        // };

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
