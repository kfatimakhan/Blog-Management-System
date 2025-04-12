<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'tags', 'comments.user', 'likes'])
            ->where(function($query) {
                $query->where('visibility', 'public')
                    ->orWhere('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'tags' => Tag::all()
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = Auth::user()->posts()->create($request->validated());

        if ($request->hasFile('image')) {
            $post->update(['image' => $request->file('image')->store('posts', 'public')]);
        }

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return Inertia::render('Posts/Show', [
            'post' => $post->load(['user', 'tags', 'comments.user', 'likes.user'])
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        if ($request->hasFile('image')) {
            $post->update(['image' => $request->file('image')->store('posts', 'public')]);
        }

        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
