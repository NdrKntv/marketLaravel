<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'body', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'avatar');
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->select('id', 'category_id', 'title', 'slug', 'rating')
            ->with('category:categories.id,categories.slug');
    }
}
