<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur.
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Mettre à jour les informations du profil de l'utilisateur.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        dd($user);

        // Valider les données reçues
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save(); // Sauvegarder les modifications

        // Retourner une réponse JSON
        return response()->json(['success' => true, 'message' => 'Profil mis à jour avec succès.']);

    }
}
