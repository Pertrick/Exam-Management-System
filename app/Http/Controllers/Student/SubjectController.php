<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AccessPin;
use Illuminate\Http\Request;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = auth()->user()->courses()->select('courses.id', 'courses.name')->get();
        $subjects = Subject::with('courses:id,name')
            ->whereHas('courses', function ($q) {
                $q->whereIn('courses.id', auth()->user()->courses->pluck('id'));
            })
            ->select('subjects.id', 'subjects.code', 'subjects.name', 'subjects.description') // Fully qualified column names
            ->get();

        $user_subjects = auth()->user()->activeSubjects()->get();
        return view('student.subject.index', compact('subjects', 'user_subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = auth()->user()->courses()->select('courses.id', 'courses.name')->get();
        $subjects = Subject::with('courses:id,name')
            ->whereHas('courses', function ($q) {
                $q->whereIn('courses.id', auth()->user()->courses->pluck('id'));
            })
            ->select('subjects.id', 'subjects.code', 'subjects.name', 'subjects.description')
            ->get();


        return view('student.subject.create', compact('subjects'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'subject' => 'required',
            'code' => 'required'
        ]);

        $input = $request->all();

        $acp = AccessPin::where("pin", $input['code'])->latest()->first();

        if (!$acp) {
            return redirect()->back()->with('error', 'Incorrect pin. Kindly check and try again');
        }

        if ($acp->status == 1 || $acp->used_by != null) {
            return redirect()->back()->with('error', 'This pin has already been used. Kindly contact the admin for a new pin');
        }

        $acp->status = 1;
        $acp->used_by = Auth::id();
        $acp->used_on = now();
        $acp->save();

        auth()->user()->subjects()->attach($request->subject, [
            'expires_at' => now()->addYear()
        ]);
        return redirect()->route('student.subject.index')->with('success', 'subject saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
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
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->subjects()->detach($id);
        return redirect()->back()->with('success', 'Subject removed successfully!');
    }
}
