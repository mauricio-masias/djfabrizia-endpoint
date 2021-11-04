<?php

namespace App\Http\Controllers\More;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\MoreService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class MoreController extends Controller
{
    protected $more_cache_key = '';

    public function __construct()
    {
        // request structure /more/mixes/2_952 [pagination_page id]
    }

    public function getMore( $section, $pages )
    {
        if( ! is_string( $section ) ) {
            return ErrorService::verboseError( $section, 'wrong_slug_format' );
        }

        if( ! is_string( $pages ) ) {
            return ErrorService::verboseError( $pages, 'wrong_slug_format' );
        }

        $more = explode( "_", trim( $pages ) );
        $page_id   = $more[1];

        if( ! Post::pageExist( $page_id ) ) {
            return ErrorService::verboseError( $page_id, 'page_not_found' );
        }

        $metadata = Post::getPostMeta( $page_id );
        $this->more_cache_key = MoreService::buildCacheKey( $section, $more );

        return Cache::remember(
            $this->more_cache_key,
            Carbon::now()->addDays(30),
            function () use ( $more, $metadata, $section ) {

                return ( ! empty( $metadata ) )
                    ? response( MoreService::shapeResponse( $metadata, $more, $section ) )
                    : ErrorService::verboseError( $more[1], 'empty_metadata', 402 );

            }
        );
    }
}


