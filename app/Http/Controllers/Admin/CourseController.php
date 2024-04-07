<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::get(['id','name']);
        $courses = Course::with('programs')->get();
        return view('admin.courses.index', compact('courses','programs'));
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
        $this->validate($request, [
            'name' => ['required','string'],
            'programs' => ['required','array'],
            'description' => ['nullable','string']
        ]);

       $course =  Course::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'capped' => $request->capped, 'description' => $request->description]
        );

        $programs = array_filter($request->programs, function ($program) {
            return $program !== null; 
        });

        $course->programs()->sync($programs);

        return redirect()->back()->with('success', 'Request Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if ($course->programs()->exists()) {
            $course->programs()->detach();
        }
    
        $course->delete();
        return redirect()->back()->with('message', 'Program Deleted Successfully!');
    }
}
