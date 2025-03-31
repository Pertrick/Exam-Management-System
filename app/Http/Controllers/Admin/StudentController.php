<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::with('subjects')->where('role_id', 2)->where('website_id',User::WEBSITE_ID)->get();
        return view('admin.student.index', compact('students'));
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.student.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData =  $this->validate($request, [
            "name" => ['required', 'string'],
            "email" => ['required', 'string'],
            "phone" => ['sometimes', 'nullable', 'string'],
            "password" => ['sometimes', 'nullable', 'string']
        ]);

        $user = $user->update([
            "name" => $validatedData['name'],
            "email" => $validatedData["email"],
            "phone" => $validatedData["phone"] ?? $user->phone,
            "password" => !empty($validatedData["password"]) ? Hash::make($validatedData["password"])  : $user->password
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Student details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $user->subjects()->detach();
                $user->tests()->detach();
                $user->responses()->detach();
                $user->results()->detach();

                $user->delete();
            });

            return redirect()->route('admin.student.index')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.student.index')->with('failed', 'Failed to delete student!');
        }
    }
}
