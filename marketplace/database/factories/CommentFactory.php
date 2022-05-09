<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'product_id' => Product::where('active', 1)->get()->random()->id,
            'rating' => $this->faker->randomElement(['like', 'dislike', 'normal']),
            'body' => $this->faker->sentence()
        ];
    }
}
