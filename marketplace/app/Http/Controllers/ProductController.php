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

        $fTags = [];
        foreach ($categoryTags as $t) {
            if (request($t->slug)) {
                $fTags[] = $t->id;
            }
        }

        $products = Product::with('tags')->where([['category_id', $category->id], $activeToggle()])->tagFilter($fTags)
            ->filter(request(['search', 'new', 'available', 'user']));

        $maxPrice = $products->max('price');
        $minPrice = $products->min('price');

        return view('product.index', ['category' => $category, 'categoryTags' => $categoryTags, 'prices' => [$maxPrice, $minPrice],
            'products' => $products->filter(request(['minPrice', 'priceLimit']))->orderType(request('sortBy'))
                ->paginate(9)->withQueryString()]);
    }

    public function show($cSlug, Product $product)
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
