<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    
    public function show()
    {
        return view('auth.password.change');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed', 'min:8', 'max:30'],
        ]);

        if (!Hash::check($data['old_password'], $request->user()->password)) {
            return back()->withInput()->withErrors([
                'old_password' => 'Старий пароль не правильний',
            ]);
        }

        User::query()->where('id', $request->user()->id)->update(['password' => Hash::make($data['new_password'])]);

        return redirect()->route('user.edit', $request->user());
    }

}
