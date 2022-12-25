<?php

namespace App\Services;
use App\Models\Question;
use App\Models\Test;
use App\Models\Result;
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
        $question = Question::with([
            'options' => function ($query) {
                $query->where('is_correct', 1);
            }
        ])->findOrFail($question_id);
        
        if (count(array_diff($question->options->pluck('label')->toArray(), $answers))  == 0) {
            $this->points = $this->points + (int)$question->point;
        }

        return $this->points;
    }


    public function storeScore($test_id, $total_score){
        $test =  Test::withCount('questions')->findOrFail($test_id);
        $total_question = $test->questions_count;

        $percentage = ($total_score / $total_question) * 100;

       $result =  Result::create([
            'user_id' => auth()->user()->id,
            'test_id' => $test_id,
            'score' => $total_score,
            'score_percentage' => $percentage,
            'status' => $percentage > 70 ? Result::PASSED : Result::FAILED,
        ]);

        $responses = auth()->user()->responses()->where('test_id',$test_id)->whereNull('result_id')->get();

        foreach($responses as $response){
            $response->result_id = $result->id;
            $response->save();
        }

    }
}
