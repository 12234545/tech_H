<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\NewRatingPosted;

class articlecontroller extends Controller
{
    /*
    public function index()
    {
        $articles = Article::with(['creator', 'theme'])
            ->latest()
            ->paginate(10);
        $themes = Theme::all();



        return view('home/dashboard', compact('articles', 'themes'));
    }*/

    public function index(Request $request)
{
    $query = Article::with(['creator', 'theme'])->latest();

    // If a theme is selected, filter articles by theme
    if ($request->has('theme_id')) {
        $query->where('theme_id', $request->theme_id);
    }

    // If Nouveautés is selected, show articles from the last 7 days
    if ($request->has('nouveautes')) {
        $query->where('created_at', '>=', now()->subDays(7));
    }

    $articles = $query->paginate(10);
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





/*
    public function showFromNotification(Article $article, DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return view('home/dashboard', compact('article'));

    }
*/
public function showFromNotification(Article $article, DatabaseNotification $notification)
{
    $notification->markAsRead();

    $themes = Theme::all();

    return view('home/dashboard', [
        'articles' => Article::with(['creator', 'theme'])->latest()->paginate(10),
        'themes' => $themes,
        'selectedArticle' => $article,
        'highlightCommentId' => $notification->data['comment_id']
    ]);
}

public function rate(Request $request, Article $article)
{
    $rating = $request->input('rating');

    $article->ratings()->create([
        'user_id' => auth()->id(),
        'rating' => $rating
    ]);

    $article->creator->notify(new NewRatingPosted($article, auth()->user(), $rating));

    return redirect()->back()->with('success', 'Note enregistrée avec succès');
}




}
