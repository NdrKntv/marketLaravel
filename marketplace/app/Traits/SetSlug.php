<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SetSlug
{
    private function slugGenerator($title, $model)
    {
        $slug = Str::slug($title);
        $count = $model::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->withTrashed()->count();

        return $count ? "$slug-$count" : $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(fn($model) => $model->setAttribute('slug', $this->slugGenerator($model->title, $model)));
    }
}
