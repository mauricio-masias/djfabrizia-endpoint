<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;
use App\Helpers\SplitLeftRightContent as Split;

class UkGigsVenuesService
{
    public static function shapeResponse( $metadata ): array
    {
        $settings = Helper::filterMetaDataWithKeys( $metadata, '/\buk_venues_/' );
        $settings_gig = Helper::filterMetaDataWithKeys( $metadata, '/\buk_gigs_/' );


        return [
            'title' => $settings_gig['uk_gigs_title'],
            'content_left' => self::ukGigsVenues( $settings, 'left' ),
            'content_right' => self::ukGigsVenues( $settings, 'right' ),
            'status' => true
        ];
    }

    private static function ukGigsVenues( $settings, $side )
    {
        $venues = [];

        foreach ( $settings as $venue ) {
            $venues[] = $venue;
        }

        return Split::split( $venues, $side );
    }

}
