<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
    protected $table = 'dj_instagram_feed';

    protected $fillable = [
        'feed',
        'update_date',
    ];

    protected $hidden = [];

    public static function getMobileFeed()
    {
         return DB::table( 'dj_instagram_posts' )
             ->select( 'like_count', 'comments_count', 'permalink', 'caption', 'username' )
             ->orderBy('post_date', 'asc')
             ->get();
    }

}
