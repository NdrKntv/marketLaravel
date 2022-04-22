<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'role', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Product::class)
            ->select('comments.rating', 'comments.product_id', 'comments.created_at')
            ->with('product')->latest()->limit(10);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'product_user')
            ->with('category:categories.id,categories.slug,categories.title')
            ->select('id', 'category_id', 'title', 'slug', 'price', 'in_stock');
    }

    public function description()
    {
        return $this->hasOne(ShopDescription::class)->select('description', 'website', 'instagram', 'facebook');
    }
}
