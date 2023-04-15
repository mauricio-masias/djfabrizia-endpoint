<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;
use App\Models\Gallery;

class GalleryService
{
    public static function shapeResponse($metadata, $source): array
    {
        $settings = Helper::filterMetaDataWithKeys($metadata, '/\bgallery_/');

        $content = $source == 'desktop'
        ? Gallery::where('feed_id', 1)->first()
        : Gallery::getMobileFeed();

        $section[0] = [
            'title'         => $settings['gallery_title'],
            'instagram_url' => $settings['gallery_instagram_url'],
            'content'       => $source == 'desktop' ? $content->feed : $content,
            'status'        => true,
        ];

        return $section;
    }

}
