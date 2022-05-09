<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
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

        $user = null;
        if (request()->has('shopCheck')) {
            $attributes['role'] = 'shop';
            DB::transaction(function () use ($attributes, &$user) {
                try {
                    $user = User::create($attributes);
                    DB::table('shop_descriptions')->insert(['user_id' => $user->id]);
                } catch (\Exception $exception) {
                    throw ValidationException::withMessages(['name' => 'Something goes wrong, try again later =(']);
                }
            });
        } else {
            $attributes['role'] = 'human';
            $user = User::create($attributes);
        }
        auth()->login($user);
        event(new Registered($user));

        return redirect('/')->with('success', 'Welcome ' . $user->name);
    }
}
