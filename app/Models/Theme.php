<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
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
    return $this->belongsToMany(User::class, 'theme_user')
                ->withTimestamps();
}

    public function getArticlesCountAttribute()
{
    return $this->articles()->count();
}

public function getSubscribersCountAttribute()
{
    return $this->subscribers_count ?? 0;
}

public function adminSubscribers()
    {
        return $this->belongsToMany(Admin::class, 'admin_theme')
                    ->withTimestamps();
    }
    use HasFactory;
}
