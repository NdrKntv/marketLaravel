<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
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
            'category_id' => Category::all()->random()->id,
            'title' => $this->faker->sentence(),
            'price' => rand(1, 10000),
            'description' => $this->faker->paragraph(),
            'slug' => $this->faker->slug(),
            'in_stock' => $this->faker->randomElement(['available', 'coming soon', 'on order']),
            'newness' => rand(0, 1),
            'active' => rand(0, 1)
        ];
    }
}
