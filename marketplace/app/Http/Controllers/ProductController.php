<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller
{
    public function index($cSlug)
    {
        $category = Category::where('slug', $cSlug)->select(['id', 'title', 'slug'])->first();
        $categoryTags = $category->tags();

        $activeToggle = fn() => (request('user') == auth()->id() && request('inactive')) ? ['active', '<', 3] : ['active', '=', 1];

        $products = $category->products()->with('tags')->where([$activeToggle()])->tagFilter($categoryTags)
            ->filter(request(['search', 'new', 'available', 'user']));

        $maxPrice = $products->max('price');
        $minPrice = $products->min('price');

        return view('product.index', ['category' => $category, 'categoryTags' => $categoryTags, 'prices' => [$maxPrice, $minPrice],
            'products' => $products->filter(request(['minPrice', 'priceLimit']))->orderType(request('sortBy'))
                ->paginate(9)->withQueryString()]);
    }

    public function show($cSlug, $pSlug)
    {
        $product = Product::where('slug', $pSlug)
            ->get(['id', 'category_id', 'user_id', 'slug', 'title', 'price', 'description', 'in_stock', 'newness', 'created_at'])
            ->first();

        return view('product.show', ['product' => $product]);
    }

    public function create($slug)
    {
        return view('product.create');
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
