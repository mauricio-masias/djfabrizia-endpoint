<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Navigation extends Model
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

    public static function getMenu($option)
    {
        return DB::select(
            "
                SELECT
                    a.ID,
                    a.post_title as title,
                    a.menu_order,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='_menu_item_menu_item_parent') as parent,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='_menu_item_target') as target,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='_menu_item_url') as url
                FROM dj_posts a
                JOIN dj_term_relationships b ON a.ID=b.object_id
                WHERE b.term_taxonomy_id = :option
                ORDER BY a.menu_order ASC"
            , ['option' => $option]
        );
    }
}
