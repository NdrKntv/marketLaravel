<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeTagFilter($query, $fTags = [])
    {
        $query->when($fTags ?? false, fn($query, $fTags) =>
        $query->whereHas('tags', fn($query) =>
        $query->whereIn('tag_id', $fTags)));
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) => $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
        );

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
