<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function store($id)
    {
        if (DB::table('product_user')->where([['product_id', $id], ['user_id', auth()->user()->id]])->doesntExist()) {
            DB::table('product_user')->insert([
                'product_id' => $id,
                'user_id' => auth()->user()->id
            ]);
            return back()->with('success', 'Added to favorites');
        }
        return back();
    }

    public function destroy($id)
    {
        DB::table('product_user')->where([
            ['product_id', $id],
            ['user_id', auth()->user()->id]
        ])->delete();
        return back()->with('success', 'Deleted from favorites');
    }
}
