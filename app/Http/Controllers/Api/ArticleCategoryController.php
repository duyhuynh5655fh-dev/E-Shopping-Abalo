<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    public function index(Request $request) {
        $search = $request->query('search');

        if ($search) {
            $results = ArticleCategory::searchByName($search);
        } else {
            $results = ArticleCategory::all();
        }

        return response()->json($results);
    }
}
