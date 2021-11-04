<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'dj_db7_forms';

    public $timestamps = false;

    protected $fillable = [
        'form_value',
        'form_post_id',
        'form_date',
    ];

    protected $hidden = [];

    static public function getCf7FormStructure( $id )
    {
        $data = DB::table( 'dj_postmeta' )
            ->select( 'meta_value' )
            ->where( 'post_id', '=', $id )
            ->where( 'meta_key', '=', '_mail' )
            ->get();

        return $data[0]->meta_value;
    }

}
