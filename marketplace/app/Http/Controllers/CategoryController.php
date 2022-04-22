<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('home', ['categories' => Category::get(['slug', 'title', 'description', 'image'])]);
    }
}
