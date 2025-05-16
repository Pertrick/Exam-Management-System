<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\Result;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResultsExport;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Result::with([
            'testUser.test.subject',
            'testUser.test.testType',
            'testUser.user',
            'testUser.test.questions'
        ])
        ->select([
            'results.*',
            'test_user.start_time',
            'test_user.end_time',
            'users.name as user_name',
            'users.email as user_email',
            'subjects.name as subject_name',
            DB::raw('COUNT(DISTINCT CASE WHEN responses.is_correct = 1 THEN responses.id END) as correct_answers'),
            DB::raw('COUNT(DISTINCT questions.id) as total_questions')
        ])
        ->join('test_user', 'results.test_user_id', '=', 'test_user.id')
        ->join('tests', 'test_user.test_id', '=', 'tests.id')
        ->join('subjects', 'tests.subject_id', '=', 'subjects.id')
        ->join('users', 'test_user.user_id', '=', 'users.id')
        ->leftJoin('questions', 'tests.id', '=', 'questions.test_id')
        ->leftJoin('responses', function($join) {
            $join->on('responses.test_user_id', '=', 'test_user.id')
                 ->on('responses.question_id', '=', 'questions.id');
        })
        ->groupBy('results.id', 'test_user.start_time', 'test_user.end_time', 
                 'users.name', 'users.email', 'subjects.name');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('subjects.name', 'like', "%{$search}%");
            });
        }

        $results = $query->get()->groupBy('subject_name');
        $paginatedResults = $query->paginate(10);

        return view('admin.results.index', compact('results', 'paginatedResults'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($testId)
    {
        $results = Result::with([
            'testUser.test.subject',
            'testUser.test.testType',
            'testUser.user',
            'testUser.test.questions.options.image',
            'testUser.test.questions.image',
            'testUser.test.questions.responses' => function($query) {
                $query->where('is_correct', 1);
            }
        ])
        ->whereHas('testUser', function($query) use ($testId) {
            $query->where('test_id', $testId);
        })
        ->get();

        return view('admin.results.show', compact('results', 'testId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request)
    {
        $query = Result::select([
            'results.id',
            'results.score',
            'results.score_percentage',
            'results.status',
            'results.created_at',
            'test_user.test_id',
            'test_user.user_id',
            'tests.subject_id',
            'subjects.name as subject_name',
            'users.name as user_name',
            'users.email as user_email',
            'test_user.start_time',
            'test_user.end_time',
            'test_user.status as test_user_status',
            DB::raw('COUNT(DISTINCT questions.id) as total_questions'),
            DB::raw('COUNT(DISTINCT CASE WHEN responses.is_correct = 1 THEN responses.id END) as correct_answers')
        ])
        ->join('test_user', 'results.test_user_id', '=', 'test_user.id')
        ->join('tests', 'test_user.test_id', '=', 'tests.id')
        ->join('subjects', 'tests.subject_id', '=', 'subjects.id')
        ->join('users', 'test_user.user_id', '=', 'users.id')
        ->leftJoin('questions', 'tests.id', '=', 'questions.test_id')
        ->leftJoin('responses', function($join) {
            $join->on('responses.test_user_id', '=', 'test_user.id')
                 ->on('responses.question_id', '=', 'questions.id');
        })
        ->groupBy([
            'results.id',
            'results.score',
            'results.score_percentage',
            'results.status',
            'results.created_at',
            'test_user.test_id',
            'test_user.user_id',
            'tests.subject_id',
            'subjects.name',
            'users.name',
            'users.email',
            'test_user.start_time',
            'test_user.end_time',
            'test_user.status',
        ])
        ->orderBy('results.created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('subjects.name', 'like', "%{$search}%");
        }

        $results = $query->get();

        return Excel::download(new ResultsExport($results), 'results.xlsx');
    }
}
