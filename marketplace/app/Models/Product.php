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
        $query->when($fTags ?? false, fn($query, $fTags) => $query->whereHas('tags', fn($query) => $query->whereIn('tag_id', $fTags)));
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) => $query->where(fn($query) => $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%'))
        );

        $query->when($filters['new'] ?? false, fn($query) => $query->where('newness', 1));

        $query->when($filters['available'] ?? false, fn($query) => $query->where('in_stock', 'available'));

        $query->when($filters['user'] ?? false, fn($query, $userId) => $query->where('user_id', $userId));

        $query->when($filters['priceLimit'] ?? false, function ($query, $priceLimit) use ($filters) {
            isset($filters['minPrice']) ? $operator = '>=' : $operator = '<=';
            $query->where('price', $operator, $priceLimit);
        });
    }

    public function scopeOrderType($query, $type)
    {
        $query->when($type ?? "id-DESC", function ($query, $type) {
            $colType = explode('-', $type);
            $query->orderBy($colType[0], $colType[1]);
        });
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
