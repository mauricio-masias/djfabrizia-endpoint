<?php

namespace App\Helpers;


class SplitLeftRightContent
{
    public static function split( $venues, $side )
    {
        $len = count( $venues );
        return ( $side == 'left' ) ? array_slice( $venues, 0, $len / 2 ) : array_slice( $venues, $len / 2 );
    }
}

