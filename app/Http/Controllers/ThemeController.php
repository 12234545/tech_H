<?php

namespace App\Http\Controllers;

USE App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;


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
    public function myThemes()
{
    $admin = Auth::guard('admin')->user();
    $themes = Theme::where('responsible', $admin->firstname . ' ' . $admin->lastname)
        ->get();

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

    $themes = Theme::where('responsible', $adminFullName)->get();

    return view('admin.auth.theme-articles', compact('articles', 'themes', 'theme'));
}
}
