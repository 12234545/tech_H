<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Theme;
use App\Models\User;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user', 'theme'])
            ->latest()
            ->get();

        $themes = Theme::all();

        return view('dashboard', compact('articles', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required',
            'theme_id' => 'required|exists:themes,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['image'] = $path;
        }

        $article = auth()->user()->articles()->create($validated);

        return redirect()->back()->with('success', 'Article publié avec succès');
    }
}

?>

