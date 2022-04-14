<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::with('comments:comments.rating,comments.product_id,comments.created_at,comments.user_id')
            ->where('id', $id)->get(['id', 'role', 'name', 'avatar', 'created_at', 'phone'])->first();
//        dd($user);
//        return view('user.show', ['user' => $user->only(['id', 'role', 'name', 'avatar', 'created_at', 'phone']), 'comments' => $user->comments()->get(['comments.rating'])]);
        return view('user.show', ['user' => $user]);
    }
}
