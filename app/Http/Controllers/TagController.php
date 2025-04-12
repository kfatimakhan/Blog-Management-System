<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    /**
     * Display a listing of all tags
     */
    public function index(): Response
    {
        $tags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->paginate(20);

        return Inertia::render('Tags/Index', [
            'tags' => $tags,
            'popularTags' => Tag::withCount('posts')
                ->orderBy('posts_count', 'desc')
                ->limit(10)
                ->get()
        ]);
    }

    /**
     * Display posts associated with a specific tag
     */
    public function show(Tag $tag): Response
    {
        $posts = $tag->posts()
            ->with(['user', 'tags'])
            ->where('visibility', 'public')
            ->latest()
            ->paginate(10);

        return Inertia::render('Tags/Show', [
            'tag' => $tag,
            'posts' => $posts,
            'relatedTags' => Tag::whereHas('posts', function($query) use ($tag) {
                $query->whereIn('id', $tag->posts()->pluck('id'));
            })
            ->where('id', '!=', $tag->id)
            ->limit(5)
            ->get()
        ]);
    }

    /**
     * Handle tag creation (AJAX endpoint)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name'
        ]);

        $tag = Tag::create([
            'name' => $request->name
        ]);

        return response()->json([
            'tag' => $tag,
            'message' => 'Tag created successfully'
        ]);
    }

    /**
     * Search tags (AJAX endpoint for autocomplete)
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        $tags = Tag::where('name', 'like', '%'.$request->query.'%')
            ->limit(10)
            ->get();

        return response()->json($tags);
    }
}
