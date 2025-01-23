<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;



class CommentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'content' => 'required|string',
                'article_id' => 'required|exists:articles,id',
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Utilisateur non authentifié'], 401);
            }

            $comment = Comment::create([
                'user_id' => $user->id,
                'article_id' => $request->input('article_id'),
                'content' => $request->input('content'),
            ]);

            return response()->json([
                'id' => $comment->id,
                'user_name' => $user->name,
                'content' => $comment->content,
                'date' => $comment->created_at,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création du commentaire'], 500);

        }
    }
}
