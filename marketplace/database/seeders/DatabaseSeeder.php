<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cats = [['Books', 'books_category_bg.jfif', 'books'],
            ['Bags', 'bags_category_bg.jpg', 'bags'],
            ['Sport equipment', 'sport_inventory_category_bg.jpg', 'sport-equipment']];
        foreach ($cats as $c) {
            Category::factory()->create([
                'title' => $c[0],
                'image' => $c[1],
                'slug' => $c[2]
            ]);
        }
        User::factory(5)->create()->each(fn($user) => $user->role != 'shop' ?: $user->description()->create());
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@ad.ad',
            'password' => 'admin11',
            'role' => 'admin'
        ]);
        Tag::factory(20)->create();
        Product::factory(100)->create()->each(fn($product) => $product->tags()
            ->attach(Tag::where('category_id', $product->category_id)->inRandomOrder()->limit(rand(0, 4))->get('id')));
        Comment::factory(250)->create();

//        for ($i = 0; $i < 100; $i++) {
//            $cId = Category::all()->random()->id;
//            DB::table('product_tag')->insert([
//                'tag_id' => Tag::where('category_id', $cId)->get()->random()->id,
//                'product_id' => Product::where('category_id', $cId)->get()->random()->id
//            ]);
//        }
    }
}
