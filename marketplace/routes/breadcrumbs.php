<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\URL;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});
Breadcrumbs::for('products', function ($trail, $category) {
    $trail->parent('home');
    $trail->push(is_array($category) ? $category['category']->title : $category->title, route('products', $category));
});
Breadcrumbs::for('product', function ($trail, $category, $product) {
    $prevUrl = parse_url(URL::previous());
    if (isset($prevUrl['path']) && $prevUrl['path'] == '/' . $category->slug . '/products' && isset($prevUrl['query'])) {
        parse_str($prevUrl['query'], $params);
        $params['category'] = $category;
    } else {
        $params = $category;
    }
    $trail->parent('products', $params);
    $trail->push($product->title, route('product', [$category, $product]));
});
