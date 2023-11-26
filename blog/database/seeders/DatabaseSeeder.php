<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $users = \App\Models\User::factory(10)->create();

        $users->each(function ($user) {
            $user->posts()->saveMany(\App\Models\Post::factory(10)->make());
        });

        $posts = \App\Models\Post::all();

        $posts->each(function ($post) use ($users) {
            $post->comments()->saveMany(\App\Models\Comment::factory(10)->make([
                'user_id' => $users->random()->id,
            ]));
        });
    }
}
