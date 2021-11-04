<?php

namespace App\Helpers;


class FilterPostMeta
{
    public static function filterMetaData( $metadata, $pattern ): array
    {
        $data = [];

        foreach ( $metadata as $item ) {
            if ( preg_match( $pattern, $item->meta_key ) ) {
                $data[] = $item->meta_value;
            }
        }

        return $data;
    }

    public static function filterMetaDataWithKeys( $metadata, $pattern ): array
    {
        $data = [];

        foreach ( $metadata as $item ) {
            if ( preg_match( $pattern, $item->meta_key ) ) {
                $data[$item->meta_key] = $item->meta_value;
            }
        }

        return $data;
    }
}

