<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function store(Product $product)
    {
        $product->comments()->create([
            'user_id' => request()->user()->id,
            'body' => request('body'),
            'rating' => request('rate')
        ]);
        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('updateDelete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted');
    }

    public function update(Comment $comment)
    {
        $this->authorize('updateDelete', $comment);
        $comment->update([
            'body' => request('body'),
            'rating' => request('rate')
        ]);
        return back()->with('success', 'Comment updated');
    }
}
