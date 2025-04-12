<?php

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Page Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'publicPosts' => Post::with(['user', 'tags'])
            ->where('visibility', 'public')
            ->latest()
            ->take(6)
            ->get(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

// Authentication Routes
Route::get('/login', [UserController::class, 'LoginPage'])->name('login.page');
Route::get('/register', [UserController::class, 'RegistrationPage'])->name('registration.page');
Route::get('/forgot-password', [UserController::class, 'ForgotPasswordPage'])->name('forgot.password.page');
Route::get('/reset-password', [UserController::class, 'ResetPasswordPage'])->name('reset.password.page');

// Main Application Routes
Route::get('/', [PostController::class, 'Index'])->name('Posts.Index');
Route::get('/dashboard', [PostController::class, 'DashboardPage'])->name('dashboard.page')->middleware('auth');

// Post Routes
Route::get('/posts', [PostController::class, 'AllPostsPage'])->name('posts.all.page');
Route::get('/posts/create', [PostController::class, 'CreatePostPage'])->name('posts.create.page')->middleware('auth');
Route::get('/posts/{post}', [PostController::class, 'ShowPostPage'])->name('posts.show.page');
Route::get('/posts/{post}/edit', [PostController::class, 'EditPostPage'])->name('posts.edit.page')->middleware('auth');

// Profile Routes
Route::get('/profile', [UserController::class, 'ProfilePage'])->name('profile.page')->middleware('auth');
Route::get('/profile/{user}', [UserController::class, 'PublicProfilePage'])->name('profile.public.page');

// Tag Routes
Route::get('/tags', [TagController::class, 'AllTagsPage'])->name('tags.all.page');
Route::get('/tags/{tag}', [TagController::class, 'ShowTagPage'])->name('tags.show.page');

// Bookmark Routes
Route::get('/bookmarks', [BookmarkController::class, 'BookmarksPage'])->name('bookmarks.page')->middleware('auth');

// Notification Routes
Route::get('/notifications', [NotificationController::class, 'NotificationsPage'])->name('notifications.page')->middleware('auth');

/*
|--------------------------------------------------------------------------
| API Routes (For form submissions/AJAX calls)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    // Authentication
    Route::post('/login', [UserController::class, 'Login'])->name('login');
    Route::post('/register', [UserController::class, 'Register'])->name('register');
    Route::post('/logout', [UserController::class, 'Logout'])->name('logout');

    // Posts
    Route::post('/posts', [PostController::class, 'Store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'Update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'Destroy'])->name('posts.destroy');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'Store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'Destroy'])->name('comments.destroy');

    // Tags
    Route::post('/tags', [TagController::class, 'Store'])->name('tags.store');

    // Likes
    Route::post('/posts/{post}/likes', [LikeController::class, 'Toggle'])->name('likes.toggle');

    // Bookmarks
    Route::post('/posts/{post}/bookmarks', [BookmarkController::class, 'Toggle'])->name('bookmarks.toggle');

    // Notifications
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'MarkAsRead'])->name('notifications.mark.read');
});
