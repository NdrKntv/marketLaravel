<?php

namespace App\Models;

use App\Traits\SetSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SetSlug;

    public function products()
    {
        return $this->hasMany(Product::class)
            ->select('id', 'user_id', 'title', 'price', 'description', 'slug', 'in_stock', 'newness', 'rating', 'active', 'created_at');
    }

    public function userProfileProducts($id)
    {
        return $this->hasMany(Product::class)->with('tags:tags.id,tags.title')
            ->where([['user_id', $id], ['active', 1]])->latest()->limit(5)
            ->get(['id', 'title', 'slug', 'price', 'created_at']);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class)->get(['id', 'slug', 'title']);
    }
}
