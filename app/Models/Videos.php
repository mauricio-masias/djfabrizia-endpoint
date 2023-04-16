<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Videos extends Model
{
    protected $table = 'dj_posts';

    protected $fillable = [
        'post_id',
        'post_title',
        'post_parent',
        'menu_order',
        'post_type',
        'display_name',
    ];

    protected $hidden = [];

    public static function getAll()
    {
        $rows = DB::select(
            "    SELECT
                    a.post_title as title,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='video_id') as id,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='video_title') as title,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='video_time') as times
                 FROM dj_posts a
                 WHERE a.post_type = :option
                 ORDER BY a.post_date DESC"
            ,
            ['option' => 'Videos']
        );

        return !empty($rows[0]->title) ? $rows : [];
    }

}
