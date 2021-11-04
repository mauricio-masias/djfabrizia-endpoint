<?php

namespace App\Services;


class MoreService
{
    public static function shapeResponse( $metadata, $more, $section ): array
    {
        $next_page = $more[0];

        switch ( $section ) {
            case 'mixes':
                return MixesService::shapeResponse( $metadata, $next_page );
                break;

            case 'releases':
                return ReleasesService::shapeResponse( $metadata, $next_page );
                break;

            case 'playlists':
                return PlaylistsService::shapeResponse( $metadata, $next_page );
                break;

            default :
                return [];
                break;
        }
    }

    public static function buildCacheKey( $section, $more ): string
    {
        return strtoupper( $section ) . '_MORE_' . $more[0];
    }

}
