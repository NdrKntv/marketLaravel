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
            'password' => 'required|string|min:6'
        ]);
        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages(['password' => 'Wrong email or password']);
        }
        session()->regenerate();

        $redirect = request('redirectLink');
        !str_contains($redirect, 'reset-password') ?: $redirect = null;

        return redirect($redirect ?? '/')->with('success', 'Hello, ' . auth()->user()->name);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye');
    }
}
