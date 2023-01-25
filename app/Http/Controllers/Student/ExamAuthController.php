<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AccessPin;
use Illuminate\Http\Request;

class ExamAuthController extends Controller
{
    public function index(){
        return view('student.exam-auth.index');
    }

    public function store(Request $request){

        $this->validate($request, [
            'password' => 'required'
        ]);
        $password =$request->password;
        $access_pins = AccessPin::pluck('pin')->toArray();
        if(in_array($password, $access_pins, true)){
           $access_pin =  AccessPin::where('pin',$password)->first();
           $access_pin->status =1;
           $access_pin->used_by = auth()->user()->id;
           $access_pin->used_on = now();
           $access_pin->save();

           return redirect()->route('student.test.index')->with('message', 'Pin correct!');
        }

          return redirect()->back()->with('message', 'Incorrect Pin!');
    }
}
