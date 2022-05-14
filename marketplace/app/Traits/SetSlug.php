<?php

namespace App\Traits;

trait SetSlug
{
    protected static function boot()
    {
        parent::boot();

        static::creating(fn($model) => $model->setAttribute('slug', slugGenerator($model->title, $model)));
    }
}
