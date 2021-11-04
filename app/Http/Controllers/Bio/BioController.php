<?php

namespace App\Http\Controllers\Bio;

use App\Http\Controllers\Controller;
use App\Models\Post;

use App\Services\BioService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class BioController extends Controller
{
    public function __construct()
    {
        // id:7 - bio API content
    }

    public function getPage( $page ): object
    {
        if ( (int)$page <= 0 || !Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'page_not_found' );
        }

        $metadata = Post::getPostMeta( $page );

        return Cache::remember(
            BIO_CACHE_KEY,
            Carbon::now()->addDays( 30 ),
            function () use ( $page, $metadata ) {
                return ( !empty( $metadata ) )
                    ? response( BioService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );
            }
        );
    }
}


