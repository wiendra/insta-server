<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'image',
        'order',
    ];

    protected $appends = ['image_url'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}