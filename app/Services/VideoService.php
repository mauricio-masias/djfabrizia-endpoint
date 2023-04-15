<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;
use App\Models\Videos;

class VideoService
{
    public static function shapeResponse($metadata): array
    {
        $settings      = Helper::filterMetaDataWithKeys($metadata, '/\bvideo_/');
        $content       = Videos::getAll();
        $content_chunk = self::sortVideos($content);

        $section[0] = [
            'title'          => $settings['video_title'],
            'yt_id'          => $settings['video_channel_id'],
            'content_right'  => $content_chunk[2],
            'content_middle' => $content_chunk[1],
            'content_left'   => $content_chunk[0],
            'content_all'    => $content,
            'status'         => true,
        ];
        return $section;
    }

    private static function sortVideos($content): array
    {
        $content_chunk = [];

        foreach ($content as $key => $video) {
            switch ($key) {
                case ($key % 4 == 0):
                case 0: //left
                    $content_chunk[0][] = $video;
                    break;

                case ($key % 3 == 0): //right
                    $content_chunk[2][] = $video;
                    break;

                default: //middle
                    $content_chunk[1][] = $video;
                    break;
            }
        }

        return $content_chunk;
    }

}
