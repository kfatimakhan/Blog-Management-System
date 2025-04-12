<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blog Management System') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <x-application-logo class="h-8 w-auto" />
                            <span class="ml-2 text-xl font-bold text-gray-900">BlogHub</span>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Log in</a>
                            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to BlogHub</h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        A modern platform for creating, sharing, and discovering amazing content.
                    </p>
                </div>

                <!-- Featured Posts -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Featured Posts</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredPosts as $post)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('posts.show', $post) }}">
                                <img src="{{ $post->image ? asset('storage/'.$post->image) : asset('images/default-post.jpg') }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-48 object-cover">
                            </a>
                            <div class="p-6">
                                <div class="flex items-center mb-2">
                                    <img src="{{ $post->user->profile_pic ? asset('storage/'.$post->user->profile_pic) : asset('images/default-profile.png') }}"
                                         alt="{{ $post->user->name }}"
                                         class="w-8 h-8 rounded-full mr-2">
                                    <span class="text-sm">{{ $post->user->name }}</span>
                                </div>
                                <a href="{{ route('posts.show', $post) }}" class="block">
                                    <h3 class="text-xl font-semibold mb-2 hover:text-indigo-600">{{ $post->title }}</h3>
                                </a>
                                <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                    <div class="flex space-x-2">
                                        @foreach($post->tags->take(2) as $tag)
                                        <span class="px-2 py-1 bg-gray-100 text-xs rounded-full">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="bg-indigo-50 rounded-lg p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Ready to start blogging?</h2>
                    <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                        Join our community of writers and readers today. Share your stories, connect with others, and discover amazing content.
                    </p>
                    @guest
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                            Log In
                        </a>
                    </div>
                    @else
                    <a href="{{ route('posts.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Create Your First Post
                    </a>
                    @endguest
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <x-application-logo class="h-6 w-auto" />
                            <span class="ml-2 text-lg font-semibold text-gray-900">BlogHub</span>
                        </a>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-gray-900">About</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900">Terms</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900">Privacy</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900">Contact</a>
                    </div>
                </div>
                <div class="mt-8 text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} BlogHub. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
