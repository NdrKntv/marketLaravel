<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Category $category)
    {
        return view('product.index', ['products' => Product::latest()
            ->where([['category_id', $category->id], ['active', 1]])->paginate(9)->withQueryString()]);
    }
}
