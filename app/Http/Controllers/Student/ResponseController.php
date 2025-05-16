<?php

namespace App\Http\Controllers\Student;

use App\Models\Test;
use App\Models\Question;
use App\Models\Response;
use App\Models\TestUser;
use Illuminate\Http\Request;
use App\Services\ScoreService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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
        try {
            return DB::transaction(function () use ($request, $score) {
                $total_score = 0;
                $test_id = $request->test_id;

                if (!auth()->check()) {
                    Log::error('User not authenticated');
                    throw new \Exception('User not authenticated');
                }

                if (!$test_id) {
                    Log::error('Test ID is missing in request');
                    throw new \Exception('Test ID is required');
                }

                // Verify test exists
                $test = Test::find($test_id);
                if (!$test) {
                    Log::error('Test not found', ['test_id' => $test_id]);
                    throw new \Exception('Test not found');
                }

                try {
                    // Attach the user to the test and get the pivot model
                    $test->users()->attach(auth()->id(), [
                        'start_time' => now(),
                        'status' => 0
                    ]);

                    // Get the created pivot record
                    $testUser = TestUser::where('test_id', $test_id)
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->first();

                    if (!$testUser) {
                        Log::error('Failed to retrieve TestUser after attach', [
                            'user_id' => auth()->id(),
                            'test_id' => $test_id
                        ]);
                        throw new \Exception('Failed to create test user record');
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to create TestUser', [
                        'error' => $e->getMessage(),
                        'user_id' => auth()->id(),
                        'test_id' => $test_id,
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }

                foreach ($request->all() as $question_id => $answers) {
                    if (is_numeric($question_id)) {
                        $answers = array_filter($answers);
                        
                        // Get the question with correct options
                        $question = Question::with(['options' => function($query) {
                            $query->where('is_correct', 1);
                        }])->findOrFail($question_id);
                        
                        // Check if the answer is correct
                        $is_correct = false;
                        if ($question->type == Question::NO_OPTION) {
                            $is_correct = !empty($answers) && in_array(strtolower($answers[0]), $question->options->pluck('label')->toArray());
                        } else {
                            $correct_answers = $question->options->pluck('label')->toArray();
                            $is_correct = count(array_diff($correct_answers, $answers)) == 0 && count(array_diff($answers, $correct_answers)) == 0;
                        }

                        $response = Response::create([
                            'test_user_id' => $testUser->id,
                            'question_id' => $question_id,
                            'answer' => $answers,
                            'is_correct' => $is_correct
                        ]);

                        if (!$response) {
                            Log::error('Failed to create Response', [
                                'test_user_id' => $testUser->id,
                                'question_id' => $question_id
                            ]);
                            throw new \Exception('Failed to create response record');
                        }

                        $total_score += $score->calculateScore($question_id, $answers);
                    }
                }

                $testUser->update([
                    'end_time' => now(),
                    'status' => 1
                ]);

                $score->storeScore($testUser->id, $total_score);
                return redirect()->route('student.test.index')->with('success', 'Exam submitted successfully!');
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while submitting the exam. Please try again.');
        }
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
