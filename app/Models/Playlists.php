<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Playlists extends Model
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

    public static function getRange($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $rows = DB::select(
            "    SELECT
                    a.post_title as title,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='playlist_short_name') as short_name,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='playlist_url') as url,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='playlist_uri') as uri,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='playlist_image') as image,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='owner_url') as artist_url,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='tracks_total') as total_tracks
                FROM dj_posts a
                WHERE a.post_type = :option
                ORDER BY a.post_date DESC
                LIMIT :limit OFFSET :offset"
            ,
            ['option' => 'Playlists', 'offset' => $offset, 'limit' => $limit]
        );

        return !empty($rows[0]->title) ? $rows : [];
    }

    public static function countAll()
    {
        return DB::table('dj_posts')
            ->where('post_type', '=', 'Playlists')
            ->count();
    }
}
