<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'creator_id',
        'theme_id',
        'share_link',
        'comments_count',
        'stars_count'
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    use HasFactory;
}
