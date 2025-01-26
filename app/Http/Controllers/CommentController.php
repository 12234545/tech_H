<?php

namespace App\Http\Controllers;


use App\Models\article;
use App\Models\comment;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCommentPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        //notification
        // $article->user->notify(new NewCommentPosted($article, auth()->user()));

        //Notification::send(User::all(), new NewCommentPosted($article, auth()->user()));
        if (auth()->user()->id !== $article->creator_id) {
            $article->creator->notify(new NewCommentPosted($article, auth()->user() , $comment));
        }
        return redirect()->route('dashboard', $article);
    }
/*
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
*/
/*
public function storeCommentReply(Request $request, Comment $comment)
{
    request()->validate([
        'contentreply' => 'required|min:3'
    ]);

    $reply = new Comment();
    $reply->content = request('contentreply');
    $reply->user_id = auth()->user()->id;

    $comment->comments()->save($reply);

    $article = $comment->commentable;

    // Notification aux utilisateurs concernés
    $commentCreatorId = $comment->user_id;
    $comment->user->notify(new NewCommentPosted($article, auth()->user(), $reply));
    $article->creator->notify(new NewCommentPosted($article, auth()->user(), $reply));
    return redirect()->back();
}
*/

public function storeCommentReply(Request $request, Comment $comment)
{
    request()->validate([
        'contentreply' => 'required|min:3'
    ]);

    $reply = new Comment();
    $reply->content = request('contentreply');
    $reply->user_id = auth()->user()->id;

    $comment->comments()->save($reply);

    $article = $comment->commentable;

    // Notification to comment creator if it's not the current user
    if ($comment->user_id !== auth()->user()->id) {
        $comment->user->notify(new NewCommentPosted($article, auth()->user(), $reply));
    }

    // Notification to article creator if it's not the current user
    if ($article->creator_id !== auth()->user()->id) {
        $article->creator->notify(new NewCommentPosted($article, auth()->user(), $reply));
    }

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
