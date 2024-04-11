<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\HomeService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class HomepageController extends Controller
{
    public function __construct()
    {
        // id:952 - homepage API content
    }

    public function getPage( $page )
    {
        if( (int) $page <= 0 || ! Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'not_found' );
        }

        return Cache::remember(
            HOMEPAGE_CACHE_KEY,
            Carbon::now()->addDays(30),
            function () use ( $page ) {
                $metadata = Post::getPostMeta( $page );

                return ( ! empty( $metadata ) )
                    ? response( HomeService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );

            }
        );
    }
}


