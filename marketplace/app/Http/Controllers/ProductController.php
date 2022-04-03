<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller
{
    public function index(Category $category)
    {
        foreach ($category->tags()->get() as $t) {
            if (request($t->slug)){
                $fTags[]=$t->id;
            }
        }

        return view('product.index', ['category' => $category, 'products' => Product::latest()
            ->where([['category_id', $category->id], ['active', 1]])->tagFilter($fTags)->filter(request(['search']))->paginate(9)->withQueryString()]);
    }

    public function show(Category $category, Product $product)
    {
        return view('product.show', ['product' => $product]);
    }
}
