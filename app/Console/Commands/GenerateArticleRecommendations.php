<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleRecommendation;
use App\Models\ArticleHistory;

class GenerateArticleRecommendations extends Command
{
    protected $signature = 'recommendations:generate';
    protected $description = 'Génère et envoie les recommandations d\'articles';

    public function handle()
    {/*
        $this->info('Début de la génération des recommandations...');

        $users = User::has('subscribedThemes')->get();

        foreach ($users as $user) {
            // Récupérer les thèmes suivis
            $themeIds = $user->subscribedThemes()->pluck('themes.id')->toArray();

            if (empty($themeIds)) {
                continue;
            }

            // Articles déjà lus
            $readArticleIds = ArticleHistory::where('user_id', $user->id)
                ->pluck('article_id')
                ->toArray();

            // Articles déjà recommandés
            $recommendedArticleIds = ArticleRecommendation::where('user_id', $user->id)
                ->pluck('article_id')
                ->toArray();

            // Trouver de nouveaux articles à recommander
            $articles = Article::whereIn('theme_id', $themeIds)
                ->whereNotIn('id', $readArticleIds)
                ->whereNotIn('id', $recommendedArticleIds)
                ->inRandomOrder()
                ->limit(2)
                ->get();

            foreach ($articles as $article) {
                // Créer la recommandation
                ArticleRecommendation::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id
                ]);

                // Envoyer la notification
                $user->notifications()->create([
                    'type' => 'App\Notifications\NewRecommendation',
                    'data' => [
                        'article_id' => $article->id,
                        'titreArticle' => $article->title,
                        'notification_type' => 'recommendation',
                        'user_name' => 'Système'
                    ]
                ]);


            }
        }

        $this->info('Recommandations générées avec succès !');
        */
        $this->info('Début de la génération des recommandations...');

        // Récupérer les utilisateurs avec des thèmes abonnés
        $users = User::has('subscribedThemes')->get();

        foreach ($users as $user) {
            // Récupérer les IDs des thèmes suivis par l'utilisateur
            $themeIds = $user->subscribedThemes()->pluck('themes.id')->toArray();

            if (empty($themeIds)) {
                continue; // Passer à l'utilisateur suivant si aucun thème n'est suivi
            }

            // Récupérer les IDs des articles déjà lus par l'utilisateur
            $readArticleIds = ArticleHistory::where('user_id', $user->id)
                ->pluck('article_id')
                ->toArray();

            // Récupérer les IDs des articles déjà recommandés à l'utilisateur
            $recommendedArticleIds = ArticleRecommendation::where('user_id', $user->id)
                ->pluck('article_id')
                ->toArray();

            // Trouver de nouveaux articles à recommander
            $articles = Article::whereIn('theme_id', $themeIds)
                ->whereNotIn('id', $readArticleIds)
                ->whereNotIn('id', $recommendedArticleIds)
                ->inRandomOrder()
                ->limit(2)
                ->get();

            foreach ($articles as $article) {
                // Créer la recommandation dans la table `article_recommendations`
                ArticleRecommendation::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id,
                    'is_notified' => true, // Marquer comme notifié
                    'notified_at' => now(), // Date de notification
                ]);

                // Envoyer la notification à l'utilisateur
                $user->notify(new \App\Notifications\ArticleRecommendation($article));
            }
        }

        $this->info('Recommandations générées avec succès !');
    }

}


