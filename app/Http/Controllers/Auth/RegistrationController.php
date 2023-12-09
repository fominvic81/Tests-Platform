<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{

    public function show(Request $request)
    {
        return view('auth.registration', [
            'student' => $request->routeIs('student.*'),
        ]);
    }

    public function store(Request $request)
    {
        
        $credentials = $request->validate([
            'firstname' => ['required', 'max:20'],
            'lastname' => ['required', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed', 'min:6', 'max:30'],
        ]);

        $user = new User($credentials);
        $user->password = Hash::make($credentials['password']);

        $user->save();

        $isStudent = $request->routeIs('student.*');
        $user->addRole($isStudent ? 'student' : 'teacher');

        Auth::login($user);
        
        return redirect()->intended();
    }
}
