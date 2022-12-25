<?php


namespace App\Http\Controllers\Student;

use App\Models\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ScoreService;

class ResponseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, ScoreService $score)
    {
        $total_score = 0;
        $test_id = $request->test_id;
        foreach ($request->all() as $question_id => $answers) {
            if (is_numeric($question_id)) {
                $answers = array_filter($answers);
                Response::create([
                    'user_id' => auth()->user()->id,
                    'question_id'  => $question_id,
                    'test_id' => $test_id,
                    'answer' => $answers
                ]);

               $total_score =  $score->calculateScore($question_id, $answers);
            }
        }

        $score->storeScore($test_id, $total_score);
        return redirect()->route('student.test.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
