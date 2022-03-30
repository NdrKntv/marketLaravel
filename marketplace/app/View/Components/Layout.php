<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public function render()
    {
        if (auth()->user()) {
            return view('components.layout', ['favorites' => auth()->user()->favorites]);
        }
        return view('components.layout');
    }
}
