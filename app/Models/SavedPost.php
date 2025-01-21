<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedPost extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    /**
     * Get the user that owns the saved post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that is saved.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    use HasFactory;
}
