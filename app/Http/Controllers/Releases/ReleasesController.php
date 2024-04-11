<?php

namespace App\Http\Controllers\Releases;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ReleasesService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class ReleasesController extends Controller
{
    public function __construct()
    {
        // id:952 - homepage API content
    }

    public function getPage( $page )
    {
        if( (int) $page <= 0 || ! Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'page_not_found' );
        }

        return Cache::remember(
            RELEASES_CACHE_KEY,
            Carbon::now()->addDays(30),
            function () use ( $page ) {
                $metadata = Post::getPostMeta( $page );
                
                return ( ! empty( $metadata ) )
                    ? response( ReleasesService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );

            }
        );
    }
}


