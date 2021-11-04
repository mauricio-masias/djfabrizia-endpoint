<?php

namespace App\Http\Controllers\Modal;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ModalService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class ModalController extends Controller
{
    protected $page_id = 952;
    protected $slug_available = ['bookme'];

    public function __construct()
    {
        // id:952 - homepage API settings
    }

    public function getModal( $option )
    {
        if( ! is_string( $option ) || strlen( $option ) <= 0 ) {
            return ErrorService::verboseError( $option, 'wrong_slug_format' );
        }

        if( ! in_array($option, $this->slug_available) ) {
            return ErrorService::verboseError( $option, 'slug_not_recognized' );
        }

        $metadata = Post::getPostMeta( $this->page_id );

        return Cache::remember(
            MODAL_CACHE_KEY,
            Carbon::now()->addDays(30),
            function () use ( $metadata, $option ) {

                return ( ! empty( $metadata ) )
                    ? response( ModalService::shapeResponse( $metadata, $option ) )
                    : ErrorService::verboseError( $this->page_id, 'empty_metadata', 402 );

            }
        );
    }
}


