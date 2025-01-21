<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\SavedPost;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    public function index()
    {
        $savedPosts = auth()->user()->savedPosts()->with('post')->latest()->get();
        return view('home/save', compact('savedPosts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id'
        ]);

        auth()->user()->savedPosts()->create([
            'post_id' => $request->post_id
        ]);

        return response()->json(['message' => 'Post sauvegardé avec succès']);
    }

    public function destroy($id)
    {
        auth()->user()->savedPosts()->where('post_id', $id)->delete();
        return response()->json(['message' => 'Post retiré des sauvegardes']);
    }
}
