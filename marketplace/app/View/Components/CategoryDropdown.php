<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryDropdown extends Component
{
    public function render()
    {
        $currentCategory = Category::firstWhere('slug', request()->segment(0));
        return view('components.category-dropdown', ['categories' => Category::all(),
            'currentCategory' =>Category::firstWhere('slug', request()->segment(1))]);
    }
}
