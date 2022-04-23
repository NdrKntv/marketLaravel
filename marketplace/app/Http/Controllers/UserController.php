<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::where('id', $id)->get(['id', 'role', 'name', 'avatar', 'created_at', 'phone'])->first();

        $categories = Category::whereRelation('products', [['user_id', $id], ['active', 1]])->get(['id', 'title', 'slug']);

        $products = [];
        foreach ($categories as $category) {
            $products[$category->id] = $category->userProfileProducts($id);
        }

        return view('user.show', ['user' => $user, 'categories' => $categories, 'products' => $products]);
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->get(['id', 'role', 'name', 'avatar', 'phone'])->first();
        if ($user->role == 'shop') {
            $description = $user->description;
        }

        return view('user.edit', ['user' => $user, 'description' => $description ?? false]);
    }

    public function update($id)
    {
        $user = User::firstWhere('id', $id);
        request()->validate([
            'avatar' => 'image|nullable',
            'passwordCheck' => 'required|current_password',
            'password' => 'min:6|nullable',
            'confirmNewPassword' => 'same:password'
        ]);
        $userAtt = request()->validate([
            'phone' => 'min:10|max:13|nullable',
            'name' => ['required', 'max:32', 'min:2', Rule::unique('users', 'name')->ignore($id)]
        ]);
        !request('password') ?: $userAtt['password'] = request('password');
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        (!request()->hasFile('avatar')) ?: $userAtt['avatar'] = request()->file('avatar')->store('avatar');
        if (request('deleteAvatar')) {
            $userAtt['avatar'] = null;
            Storage::delete($user->avatar);
        }

        $descriptionAtt = request()->validate([
            'description' => 'max:1500',
            'website' => 'url|nullable',
            'instagram' => 'url|nullable',
            'facebook' => 'url|nullable'
        ]);

        if ($descriptionAtt) {
            $user->description()->update($descriptionAtt);
        }
        $user->update($userAtt);

        return redirect('/user' . $user->id)->with('success', 'Edited');
    }
}
