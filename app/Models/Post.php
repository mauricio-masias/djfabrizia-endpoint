<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
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

    public static function pageExist(int $page_id)
    {
        $rows = DB::table('dj_posts')
            ->select('ID')
            ->where('ID', '=', $page_id)
            ->get();

        return !empty($rows[0]->ID);
    }

    public static function getPostMeta(int $page_id)
    {
        $rows = DB::table('dj_postmeta')
            ->select('meta_value', 'meta_key')
            ->where('post_id', '=', $page_id)
            ->orderBy('meta_id', 'ASC')
            ->get();

        return !empty($rows[0]->meta_value) ? $rows : [];
    }
}
