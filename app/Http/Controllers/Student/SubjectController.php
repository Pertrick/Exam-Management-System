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
        $subjects = Subject::all();
        $user_subjects = auth()->user()->subjects()->get();
        return view('student.subject.index', compact('subjects', 'user_subjects'));
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


    public function store(Request $request)
    {
        $this->validate($request,[
            'subject' => 'required',
            'code' => 'required'
        ]);

        $input=$request->all();

        $acp=AccessPin::where("pin", $input['code'])->latest()->first();

        if(!$acp){
            return redirect()->back()->with('error', 'Incorrect pin. Kindly check and try again');
        }

        if($acp->status == 1){
            return redirect()->back()->with('error', 'Pin has already been used by '.$acp->used_by);
        }

        $acp->status=1;
        $acp->used_by=Auth::id();
        $acp->save();

       auth()->user()->subjects()->attach($request->subject);
       return redirect()->back()->with('success', 'subject stored successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

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
        return redirect()->back()->with('message', 'Subject removed successfully!');
    }
}
