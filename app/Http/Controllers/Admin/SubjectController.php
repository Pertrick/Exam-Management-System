<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubjectFormRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::get();
        $subjects = Subject::with('courses:id,name')->select('id','code','name','description')->get();
        return view('admin.subject.index', compact('subjects','courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectFormRequest $request)
    {
        $request->validated();

        $subject =   Subject::updateOrCreate(
            ['code' => $request->code],
            ['name' =>$request->name, 'description' => $request->description]
        );


        $subject->courses()->attach($request->course);

        return redirect()->back()->with('message', 'Request Successful!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        $students = $subject->load('users')->users;
        return view('admin.subject.show', compact('students', 'subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->back()->with('message', 'Subject Deleted Successfully!');
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */

    public function detach(Request $request,$subjectId)
    {
        $student = $request->student;
        if($student){
            $subject = Subject::findOrFail($subjectId);
            $subject->users()->detach($student);
            return redirect()->back()->with('message', 'Student removed Successfully!');
        }

        return redirect()->back()->with('message', 'failed to removed Student!');
     
    }
}
