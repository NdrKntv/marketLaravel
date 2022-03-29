<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});
Breadcrumbs::for('categories', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->title, route('products', $category));
});
Breadcrumbs::for('product', function ($trail, $category, $product) {
    $trail->parent('categories', $category);
    $trail->push($product->title, route('product', [$category, $product]));
});
