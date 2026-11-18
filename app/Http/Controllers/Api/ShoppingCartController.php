<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'User ID not found'], 404);
        }

        $cartId = ShoppingCart::getShoppingCartId($userId);
        if (!$cartId) {
            return response()->json(['error' => 'Cart ID not found'], 404);
        }

        $items = ShoppingCartItem::showAllItemFromCart($cartId);

        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'User ID not found'], 404);
        }

        $cartId = ShoppingCart::getShoppingCartId($userId);
        if (!$cartId) {
            return response()->json(['error' => 'Cart ID not found'], 404);
        }
        ShoppingCartItem::addArticleToCart($id, $cartId);

        return response()->json(['message' => 'Add article to cart successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($shoppingcartid, $articleId)
    {
        $shoppingCartItem = ShoppingCartItem::where('ab_shoppingcart_id', $shoppingcartid)
            ->where('ab_article_id', $articleId)
            ->first();

        if (!$shoppingCartItem) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }

        $shoppingCartItem->delete();

        return response()->json(['message' => 'Item deleted successfully.'], 200);
    }
}
