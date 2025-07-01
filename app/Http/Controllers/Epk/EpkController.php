<?php

namespace App\Http\Controllers\Epk;

use App\Http\Controllers\Controller;
use App\Models\Post;

use App\Services\EpkService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class EpkController extends Controller
{
    private $cacheKey = "";

    public function __construct()
    {
        // id: 1452 - en : 1565 - it 
    }

    public function getPage( $page ): object
    {
        if ( (int)$page <= 0 || !Post::pageExist( $page ) ) {
            return ErrorService::verboseError( $page, 'page_not_found' );
        }

        if ($page === '1452') { $this->cacheKey = EPK_EN_CACHE_KEY; }
        if ($page === '1565') { $this->cacheKey = EPK_IT_CACHE_KEY; }
        if ($this->cacheKey === "") { 
            return ErrorService::verboseError($page, 'page_not_found_key'); 
        }
                
        return Cache::remember(
            $this->cacheKey,
            Carbon::now()->addDays( 30 ),
            function () use ( $page ) {
                $metadata = Post::getPostMeta( $page );
                
                return ( !empty( $metadata ) )
                    ? response( EpkService::shapeResponse( $metadata ) )
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );
            }
        );

    }

    
}


