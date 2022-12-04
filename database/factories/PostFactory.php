<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random();
        $category = Category::all()->random();
        return [
            'author_id' => $user->id,
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'post_type' => "text",
            'category_id' => $category->id
        ];
    }
}
