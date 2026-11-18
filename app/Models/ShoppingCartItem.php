<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShoppingCartItem extends Model
{
    public $timestamps = false;

    protected $table = 'ab_shoppingcart_item';

    protected $fillable = [
        'ab_shoppingcart_id',
        'ab_article_id',
        'ab_createdate',
    ];

    public static function addArticleToCart(int $articleId, int $cartId) {
        $lastArticleId = DB::table('ab_shoppingcart_item')->max('id') ?? 0;
        $newId = $lastArticleId + 1;

        DB::table('ab_shoppingcart_item')->insert([
            'id' => $newId,
            'ab_shoppingcart_id' => $cartId,
            'ab_article_id' => $articleId,
            'ab_createdate' => now()
        ]);
        return $newId;
    }

    public static function showAllItemFromCart(int $cartId) {
        return DB::table('ab_shoppingcart_item as sci')
            ->join('ab_article as a', 'sci.ab_article_id', '=', 'a.id')
            ->where('sci.ab_shoppingcart_id', $cartId)
            ->select('sci.ab_shoppingcart_id as cartId', 'a.id as articleId', 'a.ab_name as name', 'a.ab_price as price')
            ->get();
    }
}
