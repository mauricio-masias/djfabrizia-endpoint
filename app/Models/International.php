<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class International extends Model
{
    protected $table = 'dj_posts';

    protected $fillable = [
        'post_content',
        'post_title',
        'post_parent',
        'menu_order',
        'post_type',
        'display_name',
    ];

    protected $hidden = [];

    public static function getCountries($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $rows = DB::select(
            "SELECT
                a.ID,
                a.post_title as title,
                b.meta_value as active
            FROM dj_posts a
            JOIN dj_postmeta b ON a.ID = b.post_id
            WHERE a.post_type = :option
            AND b.meta_key  = 'default_country'
            ORDER BY a.post_title ASC
            LIMIT :limit OFFSET :offset"
            ,
            ['option' => 'International', 'offset' => $offset, 'limit' => $limit]
        );

        return !empty($rows[0]->ID) ? $rows : [];
    }

    public static function getCities($id) //180

    {
        $return = [];

        $rows = DB::table('dj_postmeta')
            ->select('meta_key', 'meta_value')
            ->where('post_id', '=', $id)
            ->where('meta_key', 'LIKE', 'country_city%')
            ->get();

        foreach ($rows as $city) {
            $return[$city->meta_key] = $city->meta_value;
        }
        return !empty($return) ? $return : [];
    }
}
