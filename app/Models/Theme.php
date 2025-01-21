<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['name', 'icon'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    use HasFactory;
}
