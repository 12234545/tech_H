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

    $themes = Theme::all();

    return view('home/dashboard', [
        'articles' => Article::with(['creator', 'theme'])->latest()->paginate(10),
        'themes' => $themes,
        'selectedArticle' => $article,
        'highlightCommentId' => $notification->data['comment_id']
    ]);
}

*/


public function showFromNotification(Article $article, DatabaseNotification $notification)
{
    $notification->markAsRead();
    $themes = Theme::all();

    // Préparation des données de base
    $viewData = [
        'articles' => Article::with(['creator', 'theme'])->latest()->paginate(10),
        'themes' => $themes,
        'selectedArticle' => $article,
    ];

    // Ajout du highlightCommentId seulement s'il s'agit d'une notification de commentaire
    if (isset($notification->data['notification_type']) &&
        ($notification->data['notification_type'] === 'comment' ||
         $notification->data['notification_type'] === 'reply') &&
        isset($notification->data['comment_id'])) {
        $viewData['highlightCommentId'] = $notification->data['comment_id'];
        return view('home/dashboard', $viewData);
    }
    else  {
        $notification->data['notification_type'] === 'rating';
        return view('home/dashboard', [
            'articles' => Article::with(['creator', 'theme'])->latest()->paginate(10),
            'themes' => $themes,
            'selectedArticle' => $article,
        ]);
    }

}




public function rate(Request $request, Article $article)
{
    // Valider la notation
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5'
    ]);

    // Vérifier si l'utilisateur a déjà noté cet article
    $existingRating = $article->ratings()
        ->where('user_id', auth()->id())
        ->first();

    if ($existingRating) {
        // Mettre à jour la note existante
        $existingRating->update([
            'rating' => $validated['rating']
        ]);
    } else {
        // Créer une nouvelle note
        $article->ratings()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating']
        ]);

        // Envoyer une notification au créateur de l'article
        $article->creator->notify(new NewRatingPosted($article, auth()->user(), $validated['rating']));
    }

    return redirect()->back()->with('success', 'Note enregistrée avec succès');
}





public function show($id)
{
    $article = Article::findOrFail($id);

    // Ajouter à l'historique
    ArticleHistoryController::addToHistory($article->id);

    return view('dashboard', compact('article'));
}


}
