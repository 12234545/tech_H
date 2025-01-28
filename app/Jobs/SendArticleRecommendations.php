<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleHistory;
use App\Notifications\ArticleRecommendation;
use Exception;
use Illuminate\Support\Facades\Log;

/*
class SendArticleRecommendations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public function __construct()
    {

    }


    public function handle(){
    $users = User::all();

    foreach ($users as $user) {
        // Récupérer les thèmes suivis par l'utilisateur
        $subscribedThemeIds = $user->subscribedThemes()->pluck('themes.id');

        // Récupérer l'historique des articles déjà lus
        $readArticleIds = ArticleHistory::where('user_id', $user->id)
            ->pluck('article_id');

        // Trouver des articles recommandés
        $recommendedArticles = Article::whereIn('theme_id', $subscribedThemeIds)
            ->whereNotIn('id', $readArticleIds)
            ->inRandomOrder()
            ->limit(2)
            ->get();

        // Envoyer les notifications
        foreach ($recommendedArticles as $article) {
            $user->notify(new ArticleRecommendation($article));
        }
    }
  }
}
*/
class SendArticleRecommendations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Nombre de tentatives en cas d'échec

    public function handle()
    {
        try {
            Log::info('Début du job SendArticleRecommendations');

            $users = User::has('subscribedThemes')->get();
            Log::info('Nombre d\'utilisateurs trouvés: ' . $users->count());

            foreach ($users as $user) {
                $subscribedThemeIds = $user->subscribedThemes()->pluck('themes.id')->toArray();

                if (empty($subscribedThemeIds)) {
                    Log::info("Utilisateur {$user->id} n'a pas de thèmes suivis");
                    continue;
                }

                Log::info("Traitement de l'utilisateur {$user->id} avec les thèmes: " . implode(', ', $subscribedThemeIds));

                $readArticleIds = ArticleHistory::where('user_id', $user->id)
                    ->pluck('article_id')
                    ->toArray();

                $recommendedArticles = Article::whereIn('theme_id', $subscribedThemeIds)
                    ->when(!empty($readArticleIds), function ($query) use ($readArticleIds) {
                        return $query->whereNotIn('id', $readArticleIds);
                    })
                    ->inRandomOrder()
                    ->limit(2)
                    ->get();

                Log::info("Articles recommandés trouvés pour l'utilisateur {$user->id}: " . $recommendedArticles->count());

                foreach ($recommendedArticles as $article) {
                    try {
                        $notification = new ArticleRecommendation($article);
                        $user->notify($notification);
                        Log::info("Notification envoyée pour l'article {$article->id} à l'utilisateur {$user->id}");
                    } catch (Exception $e) {
                        Log::error("Erreur lors de l'envoi de la notification: " . $e->getMessage());
                    }
                }
            }

            Log::info('Fin du job SendArticleRecommendations');
        } catch (Exception $e) {
            Log::error('Erreur dans SendArticleRecommendations: ' . $e->getMessage());
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Le job SendArticleRecommendations a échoué: ' . $exception->getMessage());
    }
}
