<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryDropdown extends Component
{
    public function render()
    {
        $categories = Category::all('title', 'slug');
        $currentCategory = $categories->firstWhere('slug', request()->segment(1));
        return view('components.category-dropdown', ['categories' => $categories, 'currentCategory' => $currentCategory]);
    }
}
