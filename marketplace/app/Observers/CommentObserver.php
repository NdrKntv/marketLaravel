<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentObserver
{
    private function ratingChanger($event, $comment)
    {
        $rates = ['like' => 10, 'normal' => 5, 'dislike' => -5];
        if ($event == 'c') {
            $newRating = $comment->product->rating + $rates[$comment->rating];
        } elseif ($event == 'd') {
            $newRating = $comment->product->rating - $rates[$comment->rating];
        } else {
            $v = $rates[$comment->rating] - $rates[$comment->getOriginal('rating')];
            $newRating = $comment->product->rating + $v;
        }
        DB::table('products')->where('id', $comment->product_id)->update(['rating' => $newRating]);

    }

    public function created(Comment $comment)
    {
        $this->ratingChanger('c', $comment);
    }

    public function updated(Comment $comment)
    {
        if ($comment->getOriginal('rating') != $comment->rating) {
            $this->ratingChanger('u', $comment);
        }
    }

    public function deleted(Comment $comment)
    {
        $this->ratingChanger('d', $comment);
    }

}
