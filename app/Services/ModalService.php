<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;

class ModalService
{
    public static function shapeResponse($metadata, $option): array
    {
        switch ($option) {
            case 'bookme':
                $settings   = Helper::filterMetaDataWithKeys($metadata, '/\bbook_me_/');
                $section[0] = [
                    'pa'     => $settings['book_me_pa'],
                    'lights' => $settings['book_me_lights'],
                    'status' => true,
                ];
                break;
            default:
                $section[0] = [];
                break;
        }

        return $section;
    }
}
