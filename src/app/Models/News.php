<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'is_featured',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function banner()
    {
        return $this->hasOne(Banner::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
