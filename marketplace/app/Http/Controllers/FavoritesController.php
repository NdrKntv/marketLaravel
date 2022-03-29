<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function store($id)
    {
        DB::table('product_user')->insert([
            'product_id'=> $id,
            'user_id'=>auth()->user()->id
        ]);
        return back()->with('success', 'Added to favorites');
    }
}
