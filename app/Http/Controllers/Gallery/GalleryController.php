<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Post;

use App\Services\GalleryService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class GalleryController extends Controller
{
    protected $page_id = 26;
    protected $cache_key = '';

    public function __construct()
    {
        // id:666 - Gallery mobile (free structure)
        // id:777 - Gallery desktop (instagram structure)
    }

    public function getPage( $source ): object
    {
        $this->cache_key = ( $source == 'desktop' ) ? GALLERY_CACHE_KEY : GALLERY_MOBILE_CACHE_KEY;

        if ( !Post::pageExist( $this->page_id ) ) {
            return ErrorService::verboseError( $this->page_id, 'page_not_found' );
        }

        return Cache::remember(
            $this->cache_key,
            Carbon::now()->addDays( 30 ),
            function () use ( $source ) {
                $metadata = Post::getPostMeta( $this->page_id );

                return ( !empty( $metadata ) )
                    ? response( GalleryService::shapeResponse( $metadata, $source ) )
                    : ErrorService::verboseError( $this->page_id, 'empty_metadata', 402 );
            }
        );
    }
}


