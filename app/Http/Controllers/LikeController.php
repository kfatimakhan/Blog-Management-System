<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Events\PostLiked;
use Illuminate\Http\Request;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // app/Http/Controllers/LikeController.php

public function toggle(Post $post)
{
    $like = $post->likes()->where('user_id', auth()->id())->first();

    if ($like) {
        $like->delete();
    } else {
        $like = $post->likes()->create(['user_id' => auth()->id()]);

        // Notify post owner if it's not their own post
        if ($post->user_id !== auth()->id()) {
            $post->user->notifications()->create([
                'type' => 'like',
                'message' => auth()->user()->username . ' liked your post'
            ]);

            event(new NewNotification($post->user));
        }
    }

    // Dispatch PostLiked event
    event(new PostLiked($post));

    return response()->json([
        'likes_count' => $post->likes()->count(),
        'is_liked' => !$like
    ]);
}
}
