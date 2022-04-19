<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller
{
    public function index(Category $category)
    {
        $activeToggle = fn() => (request('user') == auth()->user()->id && request('inactive')) ?[]: ['active', '=', 1];

//        dd($activeToggle);
        $allProducts = $category->products()->where($activeToggle());
        $maxPrice = $allProducts->max('price');
        $minPrice = $allProducts->min('price');
        $fTags = [];
        $categoryTags = $category->tags()->get();
        foreach ($categoryTags as $t) {
            if (request($t->slug)) {
                $fTags[] = $t->id;
            }
        }

        return view('product.index', ['category' => $category, 'categoryTags' => $categoryTags, 'prices' => [$maxPrice, $minPrice],
            'products' => Product::with('tags')->where([['category_id', $category->id], $activeToggle()])->tagFilter($fTags)
                ->filter(request(['search', 'new', 'available', 'minPrice', 'priceLimit', 'user']))->orderType(request('sortBy'))
                ->paginate(9)->withQueryString()]);
    }

    public function show(Category $category, Product $product)
    {
        return view('product.show', ['product' => $product,
            'comments' => $product->comments()->latest()->with('user')->get()]);
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
