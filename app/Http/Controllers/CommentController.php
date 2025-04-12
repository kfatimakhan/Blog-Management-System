<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\CommentPosted;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   // app/Http/Controllers/CommentController.php

public function store(Request $request, Post $post)
{
    $request->validate(['content' => 'required|string|max:1000']);

    $comment = $post->comments()->create([
        'user_id' => auth()->id(),
        'parent_id' => $request->parent_id,
        'content' => $request->content
    ]);

    // Dispatch the CommentPosted event
    event(new CommentPosted($comment));

    // If it's not a reply, notify the post owner
    if (!$request->parent_id && $post->user_id !== auth()->id()) {
        $post->user->notifications()->create([
            'type' => 'comment',
            'message' => auth()->user()->username . ' commented on your post'
        ]);

        event(new NewNotification($post->user));
    }

    return back();
}

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back();
    }
}
