<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'visibility'
    ];

    protected $with = ['user', 'tags'];
    protected $appends = ['short_content', 'image_url'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Accessors
    public function getShortContentAttribute()
    {
        return str_limit($this->content, 150);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeWithUserDetails($query)
    {
        return $query->with(['user' => function($q) {
            $q->select('id', 'name', 'username', 'profile_pic');
        }]);
    }

    public function scopeWithTags($query)
    {
        return $query->with(['tags' => function($q) {
            $q->select('id', 'name');
        }]);
    }
}
