<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();

        // Buat 10 post untuk admin
        Post::factory(10)->create([
            'user_id' => $admin->id,
            'start_point' => json_encode(['lat' => -6.2088, 'lng' => 106.8456]), // Jakarta
            'end_point' => json_encode(['lat' => -7.7956, 'lng' => 110.3695]), // Yogyakarta
        ])->each(function ($post) {
            // Tambahkan 1-5 komentar untuk setiap post
            Comment::factory(rand(1, 5))->create([
                'post_id' => $post->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        });

        // Buat beberapa post untuk user biasa
        User::where('role', 'user')->each(function ($user) {
            Post::factory(rand(1, 3))->create([
                'user_id' => $user->id,
                'start_point' => json_encode(['lat' => -6.2088, 'lng' => 106.8456]), // Jakarta
                'end_point' => json_encode(['lat' => -7.7956, 'lng' => 110.3695]), // Yogyakarta
            ])->each(function ($post) {
                // Tambahkan 0-3 komentar untuk setiap post
                Comment::factory(rand(0, 3))->create([
                    'post_id' => $post->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);
            });
        });
    }
}
