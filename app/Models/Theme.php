<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class theme extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'responsible',
        'subscribers_count',
        'articles_count'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }


    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'theme_user')->withTimestamps();
    }
    use HasFactory;
}
