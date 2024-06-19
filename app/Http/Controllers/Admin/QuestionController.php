<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Imports\QuestionImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\StoreQuestionFormRequest;

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
        $validator = Validator::make($request->all(), [
            'instructions' => 'required|string',
            'duration' => 'required|integer|min:1',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required|array',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.is_correct' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $test = Test::findOrFail($request->test_id);

        $test->update([
            "instruction" => $request->instructions,
            "duration" => $request->duration
        ]);

        // Iterate through each question data
        foreach ($request->questions as $questionKey => $questionData) {
            $questionText = $questionData['text'];
            $questionPoints = $questionData['points'];
            $optionsData = $questionData['options'];
            $questionType = $questionData['type'];
            $selectedOption = $questionData['selected_option'] ?? 0;

            $question = Question::where('question_test_index',$questionKey)
                                ->where('test_id',$test->id)
                                ->where('type',$questionType)
                                ->first();

            if($question){
                $question->point = $questionPoints;
                $question->type = $questionType;
                $question->subject_id = $request->subject_id;
                $question->question_test_index =  $questionKey;
                $question->test_id =  $test->id;
                $question->question = $questionText;
                $question->save();
            }else{
                $question = new Question();
                $question->point = $questionPoints;
                $question->type = $questionType;
                $question->subject_id = $request->subject_id;
                $question->question_test_index = $questionKey;
                $question->test_id =  $test->id;
                $question->question = $questionText;
                $question->save();
            }

           
            // Update or create options for this question
            foreach ($optionsData as $optionKey =>  $optionData) {
                $optionText = $optionData['text'];
                // $isCorrect = $optionData['is_correct'];
    
                // Find existing option by label and question_id
                $existingOption = Option::where('label', $optionText)
                                        ->where('question_id', $question->id)
                                        ->first();

                if ($existingOption) {

                    $existingOption->is_correct = $this->iscorrect($questionType,$selectedOption, $optionKey);
                    $existingOption->save();
                }
                    // Create a new option if it doesn't exist
                    $optionWithIndex = Option::where('option_index', $optionKey)
                                        ->where('question_id', $question->id)
                                        ->first();
                    if($optionWithIndex){
                        $optionWithIndex->label = $optionText;
                        $optionWithIndex->is_correct = $this->iscorrect($questionType,$selectedOption, $optionKey);
                        $optionWithIndex->option_index = $optionKey;
                        $optionWithIndex->question_id = $question->id;
                        $optionWithIndex->save();
                    }else{
                        $option = new Option();
                        $option->label = $optionText;
                        $option->is_correct = $this->iscorrect($questionType,$selectedOption, $optionKey);
                        $option->option_index = $optionKey;
                        $option->question_id = $question->id; 
                        $option->save();
                    }
                   
            }
           
            // $question->delete();
        }


        return redirect()->back()->with('message', 'Question saved successfully!');


        // $question =  Question::create([
        //     'question' => $request->question,
        //     'subject_id' => $request->subject_id,
        //     'type' => $request->type,
        //     'point' => $request->point,
        // ]);

        // if (!is_null($request->question_image)) {
        //     $imageService->storeQuestionImage($question, $request->question_image);
        // }

        // foreach ($request->option as $key =>  $opt) {
        //     $option = new Option();
        //     $option->question_id = $question->id;
        //     $option->label = $opt;

        //     if ($request->type == Question::OPTION) {

        //         if ($request->is_correct == $key) {
        //             $option->is_correct = "on";
        //         }
        //         $option->save();
        //     } else if ($request->type == Question::MULTI_CHOICE) {

        //         foreach ($request->is_correct as $is_correct_key => $is_correct) {
        //             if ($is_correct_key == $key) {
        //                 $option->is_correct = $is_correct;
        //             }
        //             $option->save();
        //         }
        //     } else if ($request->type == Question::NO_OPTION) {
        //         $option->is_correct = "on";
        //         $option->save();
        //     }

        //     if (!is_null($request->option_image)) {
        //         if (!empty(array_filter($request->option_image))) {
        //             foreach (array_filter($request->option_image) as $opt_key =>  $opt_image) {
        //                 if ($opt_key == $key) {
        //                     if (!is_null($opt_image)) {
        //                         $imageService->storeOptionImage($option, $opt_image);
        //                     }
        //                 }
        //             };
        //         }
        //     }
        // };

        // return redirect()->route('admin.question.index')->with('message', 'Question created successfully!');
    }

    private function iscorrect($questionType, $selectedOption, $key){
    
        if($questionType == "option" && $key == $selectedOption){
                return 1;
        }
        else if($questionType == "multiple choice"){
           if(is_array($selectedOption) && in_array($key,array_values($selectedOption))){
             return 1;
           }
         
        }else if ($questionType == "no_option"){
            return 1;
        }

        return 0;
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

                if ($request->type == Question::OPTION) {
                    if ($request->is_correct == $retrieved_key) {
                        $retrievedOption->is_correct = "on";
                    } else {
                        $retrievedOption->is_correct = "off";
                    }
                    $retrievedOption->save();
                } else if ($request->type == Question::MULTI_CHOICE) {
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


    public function import()
    {

        $subjects = Subject::get();
        return view('admin.question.import', compact('subjects'));
    }



    public function uploadExcel(Request $request)
    {
        $valiated =  $this->validate($request, [
            'subject_id' => ['required', 'string'],
            'file' => ['required', 'file']
        ]);

        $file = $valiated['file'];
        $subjectId = $valiated['subject_id'];

        $excel =  Excel::import(new QuestionImport($subjectId), $file);
        return response()->json(['message' => 'success'], 200);
    }
}
