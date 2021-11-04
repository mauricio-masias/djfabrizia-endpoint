<?php

namespace App\Services;
use App\Helpers\FilterPostMeta as Helper;
use App\Helpers\Paginate as PaginateHelp;
use App\Models\Mixes;

class MixesService
{
    public static function shapeResponse( $metadata, $page = 1 ) : array
    {
        $settings     = Helper::filterMetaDataWithKeys( $metadata,  '/\bmixes_/' );
        $raw_mixes    = Mixes::getRange( $settings['mixes_paginate'], $page );
        $tracks       = self::shapeTracks( $raw_mixes );
        $total_tracks = Mixes::countAll();

        $button_status = PaginateHelp::buttonStatus( $total_tracks, $page, $settings['mixes_paginate'] );
        $total_pages  = PaginateHelp::totalPages( $total_tracks, $settings['mixes_paginate'] );

        $section[0] = [
            'title'   => $settings['mixes_title'],
            'content' => [
                'status' => true,
                'tracks' => $tracks,
                'more_button' => [
                    'next_page'    => ( (int)$page + 1 ),
                    'current_page' => (int)$page,
                    'total_pages'  => $total_pages,
                    'label'        => $settings['mixes_more_button'],
                    'active'       => $button_status,
                ]
            ],
        ];

        return $section;
    }

    private static function shapeTracks( $mixes )
    {
        $result = [];
        if ( count( $mixes ) > 0 ) {

            foreach ( $mixes as $mix ) {
                $date = new \DateTime( $mix->mix_date );
                $result[] = [
                    'name'         => $mix->mix_short_name,
                    'url'          => $mix->mix_url,
                    'img'          => $mix->mix_img,
                    'img_small'    => $mix->mix_small_img,
                    'date'         => $date->format('Y m d'),
                    'audio_length' => $mix->mix_audio_length,
                    'tags'         => json_decode($mix->mix_tags),
                ];
            }

        } else {
            $result[0]['name'] = false;
        }
        return $result;
    }

}
