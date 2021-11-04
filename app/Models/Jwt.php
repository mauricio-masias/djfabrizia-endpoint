<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jwt extends Model
{
    protected $table = 'jwt_access_tokens';

    public $timestamps = false;

    protected $fillable = [
        'token',
        'used',
        'public_key',
        'created',
    ];

    protected $hidden = [];

}
