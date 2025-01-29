<?php

namespace App\Http\Controllers;

USE App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Admin;
use App\Notifications\ThemeSubscriptionNotification;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class ThemeController extends Controller
{


    public function subscribe(Theme $theme)
    {
        $user = Auth::user();

        if ($user->subscribedThemes()->where('theme_id', $theme->id)->exists()) {
            // Désabonner l'utilisateur
            $user->subscribedThemes()->detach($theme->id);
            $theme->decrement('subscribers_count');
            return redirect()->back()->with('success', 'Désabonnement réussi !');
        } else {
            // Abonner l'utilisateur
            $user->subscribedThemes()->attach($theme->id);
            $theme->increment('subscribers_count');
            //ajouter

            return redirect()->back()->with('success', 'Abonnement réussi !');
        }
    }


    public function adminSubscribe(Theme $theme)
{
    $admin = Auth::guard('admin')->user();

    if ($admin->subscribedThemes()->where('theme_id', $theme->id)->exists()) {
        // Désabonner l'administrateur
        $admin->subscribedThemes()->detach($theme->id);
        $theme->decrement('subscribers_count');
        return redirect()->back()->with('success', 'Désabonnement réussi !');
    } else {
        // Abonner l'administrateur
        $admin->subscribedThemes()->attach($theme->id);
        $theme->increment('subscribers_count');
        return redirect()->back()->with('success', 'Abonnement réussi !');
    }
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);
        $admin = Auth::guard('admin')->user();
        $responsible = $admin->firstname . ' ' . $admin->lastname;
        Theme::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'responsible' => $responsible ,
        ]);

        return redirect()->back()->with('success', 'Thème ajouté avec succès');
    }
    /*
    public function myThemes()
{
    $admin = Auth::guard('admin')->user();
    $themes = Theme::where('responsible', $admin->firstname . ' ' . $admin->lastname)
        ->get();

    return view('admin.auth.mesthemes', compact('themes'));
}
    */

    public function myThemes()
{
    $admin = auth()->guard('admin')->user();
    $fullName = $admin->firstname . ' ' . $admin->lastname;

    $themes = Theme::where('responsible', $fullName)
        ->withCount(['articles', 'subscribers', 'adminSubscribers'])
        ->get()
        ->map(function ($theme) {
            // Calculer le nombre total d'abonnés (utilisateurs + admins)
            $theme->subscribers_count = $theme->subscribers_count + $theme->admin_subscribers_count;
            return $theme;
        });

    return view('admin.auth.mesthemes', compact('themes'));
}

public function showThemeArticles($id)
    {
        $admin = Auth::guard('admin')->user();
        $adminFullName = $admin->firstname . ' ' . $admin->lastname;

        $theme = Theme::findOrFail($id);

        // Vérifie si le thème appartient à l'admin connecté
        if ($theme->responsible !== $adminFullName) {
            return redirect()->back()->with('error', 'Vous n\'avez pas accès à ce thème');
        }

        $articles = Article::where('theme_id', $id)
            ->with(['creator', 'comments'])
            ->latest()
            ->paginate(10);

        // Récupérer les abonnés du thème avec leur info
        $subscribers = $theme->subscribers()
            ->select('users.id', 'users.name', 'users.profile_photo')
            ->get();

        $adminSubscribers = $theme->adminSubscribers()
            ->select('admins.id', 'admins.firstname', 'admins.lastname', 'admins.profile_photo')
            ->get();

        // Combiner les abonnés utilisateurs et administrateurs
        $allSubscribers = collect();

        foreach ($subscribers as $subscriber) {
            $allSubscribers->push([
                'id' => $subscriber->id,
                'name' => $subscriber->name,
                'profile_photo' => $subscriber->profile_photo,
                'type' => 'user'
            ]);
        }

        foreach ($adminSubscribers as $subscriber) {
            $allSubscribers->push([
                'id' => $subscriber->id,
                'name' => $subscriber->firstname . ' ' . $subscriber->lastname,
                'profile_photo' => $subscriber->profile_photo,
                'type' => 'admin'
            ]);
        }

        $themes = Theme::where('responsible', $adminFullName)->get();

        return view('admin.auth.theme-articles', compact('articles', 'themes', 'theme', 'allSubscribers'));
    }

/*
    public function removeSubscriber(Theme $theme, $subscriberType, $subscriberId)
    {
        // Vérifier si l'admin actuel est le responsable du thème
        $admin = auth()->guard('admin')->user();
        if ($theme->responsible !== $admin->firstname . ' ' . $admin->lastname) {
            return redirect()->back()->with('error', 'Vous n\'avez pas la permission de gérer les abonnés de ce thème.');
        }

        try {
            if ($subscriberType === 'admin') {
                $theme->adminSubscribers()->detach($subscriberId);
            } else {
                $theme->subscribers()->detach($subscriberId);
            }
            return redirect()->back()->with('success', 'Abonné retiré avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de l\'abonné.');
        }
    }
        */
       /*
        public function removeSubscriber(Theme $theme, $subscriberType, $subscriberId)
        {
            // Vérifiez si l'admin actuel est le responsable du thème
            $admin = auth()->guard('admin')->user();
            $adminFullName = $admin->firstname . ' ' . $admin->lastname;

            if ($theme->responsible !== $adminFullName) {
                return redirect()->back()->with('error', 'Vous n\'avez pas la permission de gérer les abonnés de ce thème.');
            }

            try {
                if ($subscriberType === 'admin') {
                    // Suppression de la relation dans la table pivot admin_theme
                    DB::table('admin_theme')
                        ->where('theme_id', $theme->id)
                        ->where('admin_id', $subscriberId)
                        ->delete();
                } else {
                    // Suppression de la relation dans la table pivot theme_user
                    DB::table('theme_user')
                        ->where('theme_id', $theme->id)
                        ->where('user_id', $subscriberId)
                        ->delete();
                }

                return redirect()->back()->with('success', 'Abonné supprimé avec succès.');
            } catch (\Exception $e) {

                return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de l\'abonné.');
            }
        }
            */

            public function removeSubscriber(Theme $theme, $subscriberType, $subscriberId)
            {
                try {
                    // Vérifier les permissions
                    $admin = auth()->guard('admin')->user();
                    $adminFullName = $admin->firstname . ' ' . $admin->lastname;

                    if ($theme->responsible !== $adminFullName) {
                        return back()->with('error', 'Permission refusée.');
                    }

                    if ($subscriberType === 'admin') {
                        // Trouver l'admin
                        $subscriber = Admin::find($subscriberId);
                        if ($subscriber) {
                            // Supprimer manuellement de la table pivot
                            DB::statement('DELETE FROM admin_theme WHERE admin_id = ? AND theme_id = ?', [$subscriberId, $theme->id]);
                            // Forcer la mise à jour des relations
                            $theme->load('adminSubscribers');
                        }
                    } else {
                        // Trouver l'utilisateur
                        $subscriber = User::find($subscriberId);
                        if ($subscriber) {
                            // Supprimer manuellement de la table pivot
                            DB::statement('DELETE FROM theme_user WHERE user_id = ? AND theme_id = ?', [$subscriberId, $theme->id]);
                            // Forcer la mise à jour des relations
                            $theme->load('subscribers');
                        }
                    }

                    // Vider le cache des relations
                    $theme->unsetRelations();

                    return back()->with('success', 'Abonné supprimé avec succès.');
                } catch (\Exception $e) {

                    return back()->with('error', 'Erreur lors de la suppression.');
                }
            }
}

