<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Follower;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user();

    return view('profile.edit', compact('user'));
}
public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return redirect()->route('profile.show', ['id' => $user->id])
                     ->with('success', 'Profil mis à jour avec succès.');
}

public function destroy()
{

    $user = auth()->user();
    $user->forceDelete(); // Suppression douce

    return redirect('/')->with('success', 'Votre compte a été supprimé.');
}


    public function show()
    {
        $id = auth()->id();
        $user = User::findOrFail($id);
        $articles = Article::where('creator_id', $id)->get();
        $followers = Follower::where('creator_id', $id)->count();
        $following = Follower::where('follower_id', $id)->count();
        $themes = Theme::all();

        return view('profile', compact('user', 'articles', 'followers', 'following', 'themes'));
    }
}
