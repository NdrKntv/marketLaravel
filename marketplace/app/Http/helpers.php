<?php

use Illuminate\Support\Str;

if (!function_exists('slugGenerator')){
    function slugGenerator($title, $model)
    {
        $slug = Str::slug($title);
        $count = $model::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "$slug-$count" : $slug;
    }
}
