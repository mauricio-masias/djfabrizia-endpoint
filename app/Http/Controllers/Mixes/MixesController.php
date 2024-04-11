<?php

namespace App\Http\Controllers\Mixes;

use App\Http\Controllers\Controller;
use App\Models\Post;

use App\Services\MixesService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class MixesController extends Controller
{
    public function __construct()
    {
        // id:952 - homepage API content
    }

    public function getPage( $page ) : object
    {
        if( (int) $page <= 0 || ! Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'page_not_found' );
        }

        return Cache::remember(
            MIXES_CACHE_KEY,
            Carbon::now()->addDays(30),
            function () use ( $page ) {
                $metadata = Post::getPostMeta( $page );

                return ( ! empty( $metadata ) )
                    ? response( MixesService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );

            }
        );
    }
}


