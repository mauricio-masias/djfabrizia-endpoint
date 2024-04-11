<?php

namespace App\Http\Controllers\Standalone;

use App\Http\Controllers\Controller;
use App\Models\Post;

use App\Services\LinkTreeService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class LinkTreeController extends Controller
{
    public function __construct()
    {
        // id:1347 - linktree API content
    }

    public function getPage( $page ): object
    {
        if ( (int)$page <= 0 || !Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'page_not_found' );
        }

        //return response( LinkTreeService::shapeResponse( $metadata ) );
        
        return Cache::remember(
            LINK_TREE_CACHE_KEY,
            Carbon::now()->addDays( 30 ),
            function () use ( $page ) {
                $metadata = Post::getPostMeta( $page );
                
                return ( !empty( $metadata ) )
                    ? response( LinkTreeService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );
            }
        );
        
    }
}


