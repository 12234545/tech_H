<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['creator', 'theme'])->latest();

        if ($request->has('theme_id')) {
            $query->where('theme_id', $request->theme_id);
        }

        if ($request->has('nouveautes')) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        $articles = $query->paginate(10);
        $themes = Theme::all();

        return view('admin.auth.dashboard', compact('articles', 'themes'));
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
            'creator_id' => auth()->guard('admin')->id(),
            'theme_id' => $validated['theme_id']
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Article publié avec succès!');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::delete(str_replace('/storage/', 'public/', $article->image));
        }

        $article->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Article supprimé avec succès!');
    }
}
