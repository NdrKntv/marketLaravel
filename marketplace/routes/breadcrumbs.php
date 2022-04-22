<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});
Breadcrumbs::for('products', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->title, route('products', $category));
});
Breadcrumbs::for('product', function ($trail, $category, $product) {
    $trail->parent('products', $category);
    $trail->push($product->title, route('product', [$category, $product]));
});
