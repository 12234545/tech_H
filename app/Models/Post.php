<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        // Ajoutez ici les autres champs de votre table posts
    ];

    // Relation avec l'utilisateur qui a créé le post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les sauvegardes
    public function saves()
    {
        return $this->hasMany(SavedPost::class);
    }
    use HasFactory;
}
