<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    // Relationships
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    // Helpers
    public static function findOrCreate(array $tags)
    {
        return collect($tags)->map(function ($tag) {
            return static::firstOrCreate(['name' => $tag])->id;
        });
    }
}
