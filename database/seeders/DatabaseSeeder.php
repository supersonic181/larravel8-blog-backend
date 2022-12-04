<?php

namespace Database\Seeders;

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
        \App\Models\AccessLevel::factory(3)->create()->each(function ($level) {
            \App\Models\User::factory(10)->create([
                'access_level' => $level->level
            ]);
        });

        \App\Models\Category::factory(10)->create();
        $tags = \App\Models\Tag::factory(10)->create();
        \App\Models\Post::factory(50)->create()->each(function ($post) use ($tags) {

            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        });
        // \App\Models\User::factory(10)->create();
    }
}
