<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionController
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages(['password' => 'Wrong email or password']);
        }
        session()->regenerate();

        return redirect(request('redirectLink')??'/')->with('success', 'Hello, ' . auth()->user()->name);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect(request('redirectLink')??'/')->with('success', 'Goodbye');
    }
}
