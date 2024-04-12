<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Question;
use App\Models\Test;
use App\Models\Result;
use App\Events\ResultEmail;

class ScoreService
{
    private $points;

    public function __construct()
    {
        $this->points = 0;
    }

     /**
     * calculate the student score.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function calculateScore($question_id, $answers)
    {
        $question = Question::with('options.image')->with([
            'options' => function ($query) {
                $query->where('is_correct', 1);
            }
        ])->findOrFail($question_id);


        if(In_array(Null,$question->options->pluck('label')->toArray())){
            $option_ids = [];
             foreach($question->options as $option){
                $id = $option->where('label', null)->pluck('id');
                $option_ids = $id;
            };
          
            foreach($option_ids as $id){
            $imageName = Image::where('imageable_id',$id)->pluck('name')->first();
            $option_labels = $question->options->pluck('label')->toArray();
            array_push($option_labels, $imageName);
            }

          if (count(array_diff(array_filter($option_labels), $answers))  == 0) {
            $this->points = $this->points + (int)$question->point;
        }
          
        }else if (count(array_diff($question->options->pluck('label')->toArray(), $answers))  == 0) {
                $this->points = $this->points + (int)$question->point;
        
        }else if($question->type == Question::NO_OPTION){
            
            if(!empty($answer) && in_array(strtolower($answers[0]), $question->options->pluck('label')->toArray())){
                    $this->points = $this->points + (int)$question->point;  
                }  
            }
             

        return $this->points;
    }


    public function storeScore($testId, $totalScore){
        $test =  Test::withCount('questions')->findOrFail($testId);

        $totalPoint = $test->questions->sum('point');

        $percentage = ($totalScore / $totalPoint) * 100;

       $result =  Result::create([
            'user_id' => auth()->user()->id,
            'test_id' => $testId,
            'score' => $totalScore,
            'score_percentage' => $percentage,
            'status' => $percentage > $test->pass_mark ? Result::PASSED : Result::FAILED,
        ]);

        ResultEmail::dispatch($result);

        $responses = auth()->user()->responses()->where('test_id',$testId)->whereNull('result_id')->get();

        foreach($responses as $response){
            $response->result_id = $result->id;
            $response->save();
        }

    }
}
