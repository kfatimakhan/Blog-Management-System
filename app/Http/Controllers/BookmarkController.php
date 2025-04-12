<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the user's bookmarked posts
     */
    public function index(): Response
    {
        $bookmarks = auth()->user()
            ->bookmarks()
            ->with(['post.user', 'post.tags'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Bookmarks/Index', [
            'bookmarks' => $bookmarks
        ]);
    }

    /**
     * Toggle bookmark status for a post
     */
    public function toggle(Post $post): JsonResponse
    {
        $bookmark = auth()->user()
            ->bookmarks()
            ->where('post_id', $post->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json([
                'message' => 'Bookmark removed',
                'is_bookmarked' => false
            ]);
        }

        auth()->user()->bookmarks()->create([
            'post_id' => $post->id
        ]);

        return response()->json([
            'message' => 'Bookmark added',
            'is_bookmarked' => true
        ]);
    }
}
