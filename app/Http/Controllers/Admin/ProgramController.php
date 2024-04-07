<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::all();
        return view('admin.programs.index', compact('programs'));
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
       $validated =  $this->validate($request, [
            'name' => ['required','string', ],
            'description' => ['nullable','string']
        ]);

        Program::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'description' => $request->description]
        );

        return redirect()->back()->with('message', 'Request Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        if ($program->courses()->exists()) {
            $program->courses()->detach();
        }
    
        $program->delete();

        return redirect()->back()->with('message', 'Program Deleted Successfully!');
    }
}
