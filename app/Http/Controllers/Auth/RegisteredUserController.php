<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $programs = Program::with('courses')->get();
        return view('auth.register', compact('programs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'nullable', 'string', 'numeric:max:11'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'course' => ['required', 'string'],
            'program' => ['required', 'string']
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => Role::USER,
                'password' => Hash::make($request->password),
            ]);

            $user->courses()->attach($request->course);
            DB::commit();
        } catch (Exception $ex) {
            dd($ex->getMessage());
            DB::rollback();
            return back()->with(['message' =>  'Registration failed']);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect()->route(auth()->user()->getRedirectRouteName());
    }
}
