<?php

namespace App\Http\Controllers;

USE App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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


}
