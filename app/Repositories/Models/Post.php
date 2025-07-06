<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'enable_comment',
        'enable_like',
        'visibility',
    ];

    protected $appends = ['is_liked'];

    protected static function newFactory()
    {
        return \Database\Factories\PostFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getIsLikedAttribute()
    {
        if ($this->relationLoaded('likes')) {
            return $this->likes->isNotEmpty();
        }

        if (!Auth::check()) {
            return false;
        }

        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}