<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class comment extends Model
{
    protected $guarded = [];

    public function commentable()
    {
        return $this->morphTo();
    }


    public function comments(){
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }




    use HasFactory;
}
