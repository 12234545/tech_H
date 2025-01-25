<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class articlecontroller extends Controller
{
    public function index()
    {
        $articles = Article::with(['creator', 'theme'])
            ->latest()
            ->paginate(10);
        $themes = Theme::all();

        return view('home/dashboard', compact('articles', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|image|max:1024',
            'theme_id' => 'required|exists:themes,id'
        ]);

        $imagePath = $request->file('image')->store('public/articles');

        $article = Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => Storage::url($imagePath),
            'creator_id' => auth()->id(),
            'theme_id' => $validated['theme_id'],
            /*'share_link' => route('articles.show', ['article' => '$id']),*/
        ]);

        return redirect()->route('dashboard')->with('success', 'Article publié avec succès!');
    }

    public function rate(Request $request, Article $article)
    {
        $validated = $request->validate([
            'stars' => 'required|integer|between:1,5'
        ]);

        $article->stars_count = $validated['stars'];
        $article->save();

        return response()->json(['success' => true]);
    }






}
