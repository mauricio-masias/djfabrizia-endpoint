<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Releases extends Model
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
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_cover_art') as cover_art,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_cover_art_local') as cover_art_local,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_time') as times,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_spotify_link') as spotify_link,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_spotify_label') as spotify_label,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_itunes_link') as itunes_link,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_itunes_label') as itunes_label,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_amazon_music_link') as amazon_music_link,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_amazon_music_label') as amazon_music_label,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_traxsource_link') as traxsource_link,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_traxsource_label') as traxsource_label,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_cover_art_external') as cover_art_external,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_bpm') as bpm,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_description') as description,
                    (select c.meta_value from dj_postmeta c where post_id=a.ID and meta_key='release_track') as track
                FROM dj_posts a
                WHERE a.post_type = :option
                ORDER BY a.post_date DESC
                LIMIT :limit OFFSET :offset"
            ,
            [ 'option' => 'Releases', 'offset' => $offset, 'limit' => $limit ]
        );

        return !empty( $rows[0]->title ) ? $rows : [];
    }

    public static function getTrackName( $id ) //180
    {
        return DB::table( 'dj_postmeta' )
            ->select( 'meta_value' )
            ->where( 'post_id', '=', $id )
            ->where( 'meta_key', '=', '_wp_attached_file' )
            ->get();
    }

    public static function countAll()
    {
        return DB::table( 'dj_posts' )
            ->where( 'post_type', '=', 'Releases' )
            ->count();
    }
}
