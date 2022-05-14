<?php

namespace App\Models;

use App\Traits\SetSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, SetSlug;

    protected $guarded = ['rating'];

    public function scopeTagFilter($query, $categoryTags)
    {
        foreach ($categoryTags as $t) {
            if (request($t->slug)) {
                $fTags[] = $t->id;
            }
        }
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
        return $this->belongsTo(Category::class)->select('id', 'slug', 'title');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }

    public function images()
    {
        return $this->hasMany(Image::class)->orderByDesc('main_image')
            ->select('id', 'product_id', 'main_image', 'image_name');
    }

    public function image()
    {
        return $this->hasOne(Image::class)->where('main_image', '=', 1)
            ->select('product_id', 'image_name');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->select('id', 'slug', 'title');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->select('id', 'user_id', 'rating', 'body', 'created_at')
            ->with('user')->latest();
    }
}
