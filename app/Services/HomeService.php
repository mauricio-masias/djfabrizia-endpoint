<?php

namespace App\Services;

use App\Helpers\ApplyFormat;
use App\Helpers\FilterPostMeta as Helper;

class HomeService
{
    public static function shapeResponse($metadata): array
    {
        $section  = [];
        $rotator  = Helper::filterMetaData($metadata, '/\bhero_rotator_/');
        $about_me = Helper::filterMetaDataWithKeys($metadata, '/\babout_me_/');

        $section[0] = [
            'music_styles' => $rotator,
            'total_styles' => count($rotator),
        ];

        $section[1] = [
            'title'         => $about_me['about_me_title'],
            'content_left'  => ApplyFormat::htmlTags($about_me['about_me_left']),
            'content_right' => ApplyFormat::htmlTags($about_me['about_me_right']),
            'status'        => true,
        ];

        $section[2] = ContactService::showForm($metadata);

        return $section;
    }

}
