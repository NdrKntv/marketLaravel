<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        request()->validate(['confirmPassword' => 'same:password']);

        if (request()->has('shopCheck')) {
            $attributes['role'] = 'shop';
            DB::transaction(function () use ($attributes) {
                try {
                    $user = User::create($attributes);
                    DB::table('shop_descriptions')->insert(['user_id' => $user->id]);
                } catch (\Exception $exception) {
                    throw ValidationException::withMessages(['name' => 'Something goes wrong, try again later =(']);
                }
            });
        } else {
            $attributes['role'] = 'human';
            User::create($attributes);
        }

        return redirect('/login')->with('success', 'You create an account');
    }
}
