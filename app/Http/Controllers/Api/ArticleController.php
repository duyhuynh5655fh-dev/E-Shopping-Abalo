<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $name = $request->get('name', '');
            $categories = $request->get('categories');
            $limit = $request->get('limit');
            $offset = $request->get('offset');
            // Convert categories input into an array
            $categoryArray = is_array($categories)
                ? $categories
                : array_filter(explode(',', $categories), 'is_numeric');

            $articles = Article::searchByNameAndCategories($name, $categoryArray, $limit, $offset);

            if ($articles->isEmpty()) {
                return response()->json(['message' => 'No articles found'], 404);
            }

            return response()->json($articles);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Prüfen, ob der Benutzer authentifiziert ist
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validierung der Eingabedaten
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        try {
            $name = $request->input('name');
            $price = $request->input('price');
            $description = $request->input('description')??'';

            // Hole die ID des authentifizierten Benutzers
            $creatorId = Auth::id();

            // Benutze diese ID für die Erstellung des Artikels
            $newId = Article::addArticle($name, $price, $description, $creatorId);

            return response()->json(['id' => $newId], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

//        // Zusätzliche Bedingung
//        $userID = Auth::id();
//        if($userID == $article->creatorId){
//            $article->delete();
//            return response()->json(['message' => 'Article deleted successfully.'], 200);
//        }
//        return response()->json(['error' => 'Fail to delete article.'], 404);

        $article->delete();
        return response()->json(['message' => 'Article deleted successfully.'], 200);
    }


    /**
     * test Link.
     */
    public function testLink(Request $request)
    {
        $tmp = Auth::id();
        return response()->json(['test' => $tmp], 201);
    }
}
