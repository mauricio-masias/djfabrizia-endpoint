<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Services\NavigationService;
use App\Services\ErrorService;
use Carbon\Carbon;
use Cache;

class NavController extends Controller
{

    private $cache_key = '';

    public function __construct()
    {
        //id:3 - Footer menu
        //id:4 - Mobile menu
        //id:2 - Main menu - slug: main-menu
    }

    public function getNavById( $option )
    {
        if( (int) $option <= 0 ) {
            return ErrorService::verboseError( $option, 'wrong_slug_format' );
        }

        //Cache::forget(self::CACHE_KEY);
        switch( $option ){
            case 2: $this->cache_key = MAIN_MENU_CACHE_KEY;   break;
            case 3: $this->cache_key = FOOTER_MENU_CACHE_KEY; break;
            case 4: $this->cache_key = MOBILE_MENU_CACHE_KEY; break;
            default: return ErrorService::verboseError( $option, 'not_found' ); break;
        }

        return Cache::remember(
            $this->cache_key,
            Carbon::now()->addDays(30),
            function () use ( $option ) {

                $default_rows = Navigation::getMenu( $option );

                return (! empty( $default_rows ) )
                    ? response( NavigationService::setCustomValues( $default_rows ) )
                    : ErrorService::verboseError( $option, 'empty_result', 402 );
            }
        );
    }
}

