<?php

namespace App\Services;

use App\Models\International;
use App\Helpers\FilterPostMeta as Helper;

class InternationalVenuesService
{
    public static function shapeResponse( $metadata ): array
    {
        $settings = Helper::filterMetaDataWithKeys( $metadata, '/\binternational_/' );

        return [
            'title' => $settings['international_title'],
            'content' => self::internationalContent(),
            'status' => true
        ];
    }

    private static function internationalContent(): array
    {
        $countries = [];
        $countries_raw = International::getCountries( 20, 1 );

        foreach ( $countries_raw as $country ) {
            $countries[] = [
                'title' => $country->title,
                'active' => (int) $country->active,
                'cities' => self::cities( $country->ID ),
            ];
        }
        return $countries;
    }

    private static function cities( $country_id ): array
    {
        $cities = [];
        $cities_meta = International::getCities( $country_id );
        $total_cities = (int)$cities_meta['country_city'];

        for ( $x = 0; $x < $total_cities; $x++ ) {
            $cities[$x]['name'] = $cities_meta['country_city_' . $x . '_city_name'];
            $cities[$x]['clubs'] = [];

            $total_clubs = $cities_meta['country_city_' . $x . '_club_name'];
            for ( $y = 0; $y < (int)$total_clubs; $y++ ) {
                $cities[$x]['clubs'][] = $cities_meta['country_city_' . $x . '_club_name_' . $y . '_item_name'];
            }
        }
        return $cities;
    }

}
