<?php

namespace App\Http\Controllers;

use App\Models\Theme;
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
            return response()->json(['success' => true, 'subscribed' => false]);
        } else {
            // Abonner l'utilisateur
            $user->subscribedThemes()->attach($theme->id);
            $theme->increment('subscribers_count');
            return response()->json(['success' => true, 'subscribed' => true]);
        }
    }
}
