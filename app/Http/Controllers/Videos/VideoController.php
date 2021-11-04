<?php

namespace App\Http\Controllers\Videos;

use App\Http\Controllers\Controller;
use App\Models\Post;

use App\Services\VideoService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class VideoController extends Controller
{
    public function __construct()
    {
        // id:39 - social API content
    }

    public function getPage( $page ) : object
    {
        if( (int) $page <= 0 || ! Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'page_not_found' );
        }

        $metadata = Post::getPostMeta( $page );

        return Cache::remember(
            VIDEOS_CACHE_KEY,
            Carbon::now()->addDays(30),
            function () use ( $page, $metadata ) {

                return ( ! empty( $metadata ) )
                    ? response( VideoService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );

            }
        );

    }
}


