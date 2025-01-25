<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(article $article)
    {
        request()->validate([
            'content' => 'required|min:3'
        ]);

        $comment = new comment();
        $comment->content = request('content');
        $comment->user_id = auth()->user()->id;

        $article->comments()->save($comment);

        return redirect()->route('dashboard', $article);
    }

    public function storeCommentReply(comment $comment)
    {
        request()->validate([
            'contentreply' => 'required|min:3'
        ]);

        $reply = new comment();
        $reply->content = request('contentreply');
        $reply->user_id = auth()->user()->id;

        $comment->comments()->save($reply);

        return redirect()->back();

    }

    public function destroy(Comment $comment)
{
    if (auth()->user()->id !== $comment->user_id) {
        return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire');
    }

    // Supprimer les réponses associées
    $comment->comments()->delete();

    // Supprimer le commentaire
    $comment->delete();

    return back()->with('success', 'Commentaire supprimé avec succès');
}
}
