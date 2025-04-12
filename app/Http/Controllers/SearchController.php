<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $results = [
            'posts' => Post::search($query)
                ->where('visibility', 'public')
                ->with('user')
                ->paginate(10),
            'tags' => Tag::where('name', 'like', "%{$query}%")->limit(5)->get(),
            'users' => User::where('username', 'like', "%{$query}%")
                ->orWhere('name', 'like', "%{$query}%")
                ->limit(5)
                ->get()
        ];

        return Inertia::render('Search/Index', [
            'query' => $query,
            'results' => $results
        ]);
    }
}
