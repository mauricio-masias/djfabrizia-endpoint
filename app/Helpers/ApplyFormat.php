<?php

namespace App\Helpers;


class ApplyFormat
{
    public static function htmlTags( $string ): string
    {
        if ( substr( $string, 0, 2 ) != '<p' ) {
            $string = '<p>' . $string;
        }

        $string = str_replace( " \r\n", "<br />", $string );
        $string = str_replace( "\r\n\r\n", "</p><p>", $string );
        $string = str_replace( "\r\n", "</p>", $string );

        return $string;
    }

}

