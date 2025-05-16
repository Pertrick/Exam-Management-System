<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Question;
use App\Models\Test;
use App\Models\Result;
use App\Models\TestUser;
use App\Events\ResultEmail;
use App\Models\Response;

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

        $points = 0;

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

            if (count(array_diff(array_filter($option_labels), $answers)) == 0) {
                $points = (int)$question->point;
            }
        } else if (count(array_diff($question->options->pluck('label')->toArray(), $answers)) == 0) {
            $points = (int)$question->point;
        } else if($question->type == Question::NO_OPTION) {
            if(!empty($answers) && in_array(strtolower($answers[0]), $question->options->pluck('label')->toArray())){
                $points = (int)$question->point;
            }
        }
             
        return $points;
    }


    public function storeScore($testUserId, $totalScore){
        $testUser = TestUser::with('test.questions')->findOrFail($testUserId);
        $test = $testUser->test;

        $totalPoint = $test->questions->sum('point');

        if($totalPoint != 0){
            $percentage = ($totalScore / $totalPoint) * 100;
        }else{
            $totalScore = 0;
            $percentage = 0;
        }

        $result = Result::create([
            'test_user_id' => $testUserId,
            'score' => $totalScore,
            'score_percentage' => $percentage,
            'status' => $percentage > $test->pass_mark ? Result::PASSED : Result::FAILED,
        ]);

        ResultEmail::dispatch($result);

        // Update responses with result_id
        $responses = Response::where('test_user_id', $testUserId)->get();
                           
        foreach($responses as $response){
            $response->update([
                'result_id' => $result->id
            ]);
        }
    }
}
