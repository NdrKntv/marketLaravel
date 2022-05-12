<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->favorites);
    }

    public function store($id)
    {
        if (DB::table('product_user')->where([['product_id', $id], ['user_id', auth()->user()->id]])->doesntExist()) {
            DB::table('product_user')->insert([
                'product_id' => $id,
                'user_id' => auth()->user()->id
            ]);
        }
    }

    public function destroy($id)
    {
        DB::table('product_user')->where([
            ['product_id', $id],
            ['user_id', auth()->user()->id]
        ])->delete();
    }
}
