<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Product $product)
    {
        $product->comments()->create([
           'user_id'=>request()->user()->id,
            'body'=>request('body'),
            'rating'=>request('rate')
        ]);
        return back();
    }
}
