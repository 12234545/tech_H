<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'article_id',
        'content',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec l'article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
