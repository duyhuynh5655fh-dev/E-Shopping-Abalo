<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // /articles?search=?
    public function index(Request $request) {

        $search = $request->input('search'); // Abrufen des Suchparameters

        if($search) {
            $articles = Article::search($search);
        } else {
            $articles = Article::all();
        }
        //return view('articles/index', ['articles' => $articles, 'title' => 'Articles', 'token' => session('auth_token')]);
        return view('newsite', ['title' => 'Articles', 'token' => session('auth_token')]);
    }

    public function showArticleForm() {
        return view('articles/newarticle');
    }

    public function store(Request $request) {
        // Prüfen, ob der Benutzer authentifiziert ist
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validierung der Eingabedaten
        $request->validate([
            'ab_name' => 'required|string',
            'ab_price' => 'required|numeric|min:0.01',
            'ab_description' => 'nullable|string',
        ]);

        $name = $request->input('ab_name');
        $price = $request->input('ab_price');
        $description = $request->input('ab_description')?? '';

        // Hole die ID des authentifizierten Benutzers
        $creatorId = Auth::id();
        if(!$creatorId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Article::addArticle($name, $price, $description, $creatorId);
        return response("Erfolgreich", 200);
    }
}
