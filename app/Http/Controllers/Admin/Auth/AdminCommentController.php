<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCommentPosted;

class AdminCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function store(Article $article)
    {
        request()->validate([
            'content' => 'required|min:3'
        ]);

        $comment = new Comment();
        $comment->content = request('content');
        $comment->user_id = Auth::guard('admin')->id();

        $article->comments()->save($comment);


        if (Auth::guard('admin')->id() !== $article->creator_id) {
            $article->creator->notify(new NewCommentPosted($article, Auth::guard('admin')->user(), $comment));
        }

        return redirect()->route('admin.dashboard');
    }

    public function storeCommentReply(Comment $comment)
    {
        request()->validate([
            'contentreply' => 'required|min:3'
        ]);

        $reply = new Comment();
        $reply->content = request('contentreply');
        $reply->user_id = Auth::guard('admin')->id();

        $comment->comments()->save($reply);

        $article = $comment->commentable;


        if ($comment->user_id !== Auth::guard('admin')->id()) {
            $comment->user->notify(new NewCommentPosted($article, Auth::guard('admin')->user(), $reply));
        }

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Comment $comment)
    {

        $comment->comments()->delete();
        $comment->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Commentaire supprimé avec succès');
    }
}
