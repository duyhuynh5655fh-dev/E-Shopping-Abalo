<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShoppingCart extends Model
{
    public $timestamps = false;

    protected $table = 'ab_shoppingcart';

    protected $fillable = [
        'ab_creator_id',
        'ab_createdate',
    ];

    public static function createShoppingCart($ab_creator_id) {
        $lastCartId = DB::table('ab_shoppingcart')->max('id') ?? 0;
        $newId = $lastCartId + 1;

        DB::table('ab_shoppingcart')->insert([
            'id' => $newId,
            'ab_creator_id' => $ab_creator_id,
            'ab_createdate' => now()
        ]);
    }

    public static function getShoppingCartId($ab_creator_id) {
        return DB::table('ab_shoppingcart')->where('ab_creator_id', $ab_creator_id)->value('id');
    }
}
