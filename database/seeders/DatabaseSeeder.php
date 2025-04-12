<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create specific tags with names first
        $tagNames = [
            'Laravel', 'Vue.js', 'Inertia', 'JavaScript',
            'PHP', 'HTML', 'CSS', 'Tailwind', 'MySQL', 'Git'
        ];

        $tags = collect($tagNames)->map(function ($name) {
            return Tag::create(['name' => $name]);
        });

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password'),
            'profile_pic' => null,
            'email_verified_at' => now(),
        ]);

        // Create 10 regular users
        $users = User::factory(10)->create();

        // Combine all users including admin
        $allUsers = $users->concat([$admin]);

        // Create 30 posts (3 per user)
        $posts = Post::factory(30)->create([
            'user_id' => fn() => $allUsers->random()->id,
            'visibility' => fn() => rand(0, 1) ? 'public' : 'private',
        ]);

        // Attach 1-3 random tags to each post
        $posts->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')
            );
        });

        // Rest of your seeder code...
        // [Keep all your existing code for comments, likes, bookmarks, etc.]
    }
}
