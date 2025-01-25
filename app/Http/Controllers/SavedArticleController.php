<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedArticle;

class SavedArticleController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id'
        ]);

        // Check if already saved
        $exists = SavedArticle::where('user_id', auth()->id())
            ->where('article_id', $validated['article_id'])
            ->exists();

        if (!$exists) {
            SavedArticle::create([
                'user_id' => auth()->id(),
                'article_id' => $validated['article_id']
            ]);

            return redirect()->back()->with('success', 'Article sauvegardé !');
        }

        return redirect()->back()->with('error', 'Article déjà sauvegardé.');
    }

    public function index()
    {
        $savedArticles = SavedArticle::where('user_id', auth()->id())
            ->with('article')
            ->latest()
            ->get();

        return view('home/save', compact('savedArticles'));
    }

    public function unsave($id)
    {
        SavedArticle::where('user_id', auth()->id())
            ->where('article_id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Article retiré des sauvegardes.');
    }
}
