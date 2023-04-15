<?php

namespace App\Services;

use App\Helpers\ApplyFormat;
use App\Helpers\FilterPostMeta as Helper;

class BioService
{
    public static function shapeResponse($metadata): array
    {
        $settings = Helper::filterMetaDataWithKeys($metadata, '/\bbio_/');

        $section[0] = [
            'title'         => $settings['bio_title'],
            'content_left'  => ApplyFormat::htmlTags($settings['bio_left']),
            'content_right' => ApplyFormat::htmlTags($settings['bio_right']),
            'status'        => true,
        ];

        $section[1] = UkGigsVenuesService::shapeResponse($metadata);

        $section[2] = InternationalVenuesService::shapeResponse($metadata);

        return $section;
    }

}
