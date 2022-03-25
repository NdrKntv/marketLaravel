<?php

namespace App\Http\Controllers;

use App\Models\User;

class RegisterController
{
    public function create()
    {
        return view('auth.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|max:32|min:2|unique:users,name',
            'password' => 'required|min:6'
        ]);
        request()->has('shopCheck') ? $attributes['role'] = 'shop' : $attributes['role'] = 'human';
        User::create($attributes);
        return redirect('/login')->with('success', 'You create an account');
    }
}
