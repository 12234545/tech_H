<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleRecommendation extends Model
{
    protected $fillable = [
        'user_id',
        'article_id',
        'is_notified',
        'notified_at'
    ];

    protected $casts = [
        'is_notified' => 'boolean',
        'notified_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    use HasFactory;
}
