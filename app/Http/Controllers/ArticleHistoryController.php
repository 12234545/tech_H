<?php

namespace App\Http\Controllers;

use App\Models\ArticleHistory;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleHistoryController extends Controller
{

    public function index(Request $request)
    {
        $query = ArticleHistory::with(['article', 'user'])
            ->where('user_id', auth()->id());

        // Filtres
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $histories = $query->paginate(10);

        return view('article-history/history', compact('histories'));
    }


    public function updateStatus(Request $request, $id)
    {
        $history = ArticleHistory::findOrFail($id);

        $history->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Statut mis à jour');
    }

    // Méthode pour ajouter automatiquement à l'historique

    public static function addToHistory($articleId)
    {
        ArticleHistory::create([
            'user_id' => auth()->id(),
            'article_id' => $articleId,
            'status' => 'En cours'
        ]);
    }


   //ajouter


   //////////////////////////

   public function search(Request $request)
    {
        $searchTerm = $request->input('search_term');

        $articles = Article::where('title', 'LIKE', $searchTerm . '%')
            ->select('id', 'title')
            ->limit(5)
            ->get();

        return response()->json($articles);
    }

    public function showSearchResult($id)
    {
        $article = Article::findOrFail($id);

        // Ajouter à l'historique
        $this->addToHistory($article->id);

        // Récupérer l'historique pour la vue
        $histories = ArticleHistory::with(['article', 'user'])
            ->where('user_id', auth()->id())
            ->paginate(10);

        return view('article-history/history', compact('histories', 'article'));
    }




    public function clearAll()
{
    try {
        // Supprimer tous les enregistrements d'historique de l'utilisateur connecté
        ArticleHistory::where('user_id', auth()->id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Historique effacé avec succès'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la suppression de l\'historique'
        ], 500);
    }
}
}
