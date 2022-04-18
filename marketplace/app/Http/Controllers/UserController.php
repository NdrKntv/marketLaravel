<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ShopDescription;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::with('comments:comments.rating,comments.product_id,comments.created_at',
            'comments.product:products.id,products.category_id,products.title,products.slug',
            'comments.product.category:categories.id,categories.slug',
            'description:shop_descriptions.user_id,shop_descriptions.description,shop_descriptions.website,shop_descriptions.instagram,shop_descriptions.facebook')
            ->where('id', $id)->get(['id', 'role', 'name', 'avatar', 'created_at', 'phone'])->first();

        $categories = Category::whereRelation('products', [['user_id', $id], ['active', 1]])->get(['id', 'title', 'slug']);

        $products = [];
        foreach ($categories as $category) {
            $products[$category->id] = Product::with('tags:tags.id,tags.title')
                ->where([['user_id', $id], ['category_id', $category->id], ['active', 1]])
                ->latest()->limit(5)->get(['id', 'title', 'slug', 'price', 'created_at']);
        }

        return view('user.show', ['user' => $user, 'categories' => $categories, 'products' => $products]);
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->get(['id', 'role', 'avatar', 'phone'])->first();
        if ($user->role == 'shop') {
            $description = ShopDescription::where('user_id', $id)->get(['description', 'website', 'instagram', 'facebook'])->first();
        }

        return view('user.edit', ['user' => $user, 'description' => $description ?? false]);
    }

    public function update($id)
    {
        $userAtt = request()->validate([
            'phone' => 'min:10|max:13|nullable',
            'avatar' => 'image|nullable'
        ]);
        $descriptionAtt = request()->validate([
            'description' => 'max:1000',
            'website' => 'url|nullable',
            'instagram' => 'url|nullable',
            'facebook' => 'url|nullable'
        ]);

        $user = User::firstWhere('id', $id);
        if ($descriptionAtt) {
            $user->description()->update($descriptionAtt, ['timestamps' => false]);
        }
        $user->update($userAtt);

        return redirect('/user' . $user->id)->with('success', 'Edited');
    }
}
