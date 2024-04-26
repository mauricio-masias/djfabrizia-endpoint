<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mixes extends Model
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

    public static function getRange( $limit, $page )
    {
        $offset = $limit * ( $page - 1 );

        $rows = DB::select("
                SELECT
                    a.post_title as title,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_url') as mix_url,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_img') as mix_img,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_small_img') as mix_small_img,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_date') as mix_date,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_audio_length') as mix_audio_length,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_tags') as mix_tags,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='mix_short_name') as mix_short_name
                FROM dj_posts a
                WHERE a.post_type = :option
                ORDER BY a.post_date DESC
                LIMIT :limit OFFSET :offset"
            ,
            [ 'option' => 'Mixes', 'offset' => $offset, 'limit' => $limit ]
        );

        return !empty( $rows[0]->title ) ? $rows : [];
    }

    public static function countAll()
    {
        return DB::table( 'dj_posts' )
            ->where( 'post_type', '=', 'Mixes' )
            ->count();
    }
}
