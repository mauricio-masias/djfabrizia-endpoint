<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Services\NavigationService;
use Cache;
use Carbon\Carbon;

class NavController extends Controller
{

    private $cacheKey = '';

    public function __construct()
    {
        //id:3 - Footer menu
        //id:4 - Mobile menu
        //id:2 - Main menu - slug: main-menu
    }

    public function getNavById($option): object|array
    {
        if ((int) $option <= 0) {
            return ['error' => 'wrong nav ID'];
        }

        //Cache::forget(self::CACHE_KEY);
        switch ($option) {
            case 2:
                $this->cacheKey = MAIN_MENU_CACHE_KEY;
                break;
            case 3:
                $this->cacheKey = FOOTER_MENU_CACHE_KEY;
                break;
            case 4:
                $this->cacheKey = MOBILE_MENU_CACHE_KEY;
                break;
            default:
                return ['error' => 'no cache key found'];
        }

        //$defaultRows = Navigation::getMenu($option);
        //return NavigationService::setCustomValues($defaultRows);
        
        return Cache::remember(
            $this->cacheKey,
            Carbon::now()->addDays(30),
            function () use ($option) {
                $defaultRows = Navigation::getMenu($option);

                return (!empty($defaultRows))
                    ? NavigationService::setCustomValues($defaultRows)
                    : ErrorService::verboseError( $page, 'empty_metadata', 402 );
            }
        );
        
    }
}
