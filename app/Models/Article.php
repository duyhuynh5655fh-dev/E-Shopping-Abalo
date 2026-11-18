<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $primaryKey = 'id'; // verwendeter Primärschlüssel
    protected $table = 'ab_article'; // Name der Tabelle
    protected $fillable = ['id', 'ab_name', 'ab_price', 'ab_description', 'ab_creator_id', 'ab_createdate'];

    public static function searchByNameAndCategories($name, $categories, $limit, $offset) {
        $query = DB::table('ab_article as a')
            ->join('ab_article_has_articlecategory as ahc', 'a.id', '=', 'ahc.ab_article_id');

        if (!empty($name)) {
            $query->where('a.ab_name', 'ILIKE', '%' . trim($name) . '%');
        }

        if (!empty($categories)) {
            $query->whereIn('ahc.ab_articlecategory_id', array_filter($categories, 'is_numeric'));
        }

        return $query->limit($limit)->offset($offset)->get();
    }


    public static function addArticle(string $name, float $price, string $description, int $creatorId) {
        $lastArticleId = DB::table('ab_article')->max('id') ?? 0;
        $newId = $lastArticleId + 1;

        DB::table('ab_article')->insert([
            'id' => $newId,
            'ab_name' => $name,
            'ab_price' => $price,
            'ab_description' => $description,
            'ab_creator_id' => $creatorId,
            'ab_createdate' => now()
        ]);
        return $newId;
    }
}
