<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleCategory extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'ab_articlecategory';

    public static function searchByName(string $search) {
        return DB::table('ab_articlecategory')
            ->where('ab_name', 'ILIKE', '%' . $search . '%') // case-insensitive Suche (ILIKE)
            ->get();
    }
}
