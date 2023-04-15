<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;
use App\Helpers\Paginate as PaginateHelp;
use App\Models\Releases;

class ReleasesService
{
    public static function shapeResponse($metadata, $page = 1): array
    {
        $settings     = Helper::filterMetaDataWithKeys($metadata, '/\breleases_/');
        $raw_releases = Releases::getRange($settings['releases_paginate'], $page);
        $tracks       = self::shapeTracks($raw_releases);
        $total_tracks = Releases::countAll();

        $button_status = PaginateHelp::buttonStatus($total_tracks, $page, $settings['releases_paginate']);
        $total_pages   = PaginateHelp::totalPages($total_tracks, $settings['releases_paginate']);

        $section[0] = [
            'title'   => $settings['releases_title'],
            'content' => [
                'status'      => true,
                'tracks'      => $tracks,
                'more_button' => [
                    'next_page'    => ((int) $page + 1),
                    'current_page' => (int) $page,
                    'total_pages'  => $total_pages,
                    'label'        => $settings['releases_more_button'],
                    'active'       => $button_status,
                ],
            ],
        ];

        return $section;
    }

    private static function shapeTracks($releases): array
    {
        $result = [];
        if (count($releases) > 0) {

            foreach ($releases as $release) {

                $desc       = explode("|", $release->description);
                $track_name = strlen($release->track) > 0 ? self::getTrackMp3Name($release->track) : null;

                $result[] = [
                    'img'          => $release->cover_art == 'local' ? $release->cover_art_local : $release->cover_art_external,
                    'title'        => $release->title,
                    'bpm'          => $release->bpm,
                    'music_style'  => $desc[0],
                    'record_label' => $desc[1],
                    'year'         => $desc[2],
                    'time'         => $release->times,
                    'spoty_url'    => $release->spotify_link,
                    'spoty_t'      => $release->spotify_label,
                    'itune_url'    => $release->itunes_link,
                    'itune_t'      => $release->itunes_label,
                    'amazon_url'   => $release->amazon_music_link,
                    'amazon_t'     => $release->amazon_music_label,
                    'trax_url'     => $release->traxsource_link,
                    'trax_t'       => $release->traxsource_label,
                    'track'        => $track_name,
                ];
            }

        }
        return $result;
    }

    private static function getTrackMp3Name(Int $track): string
    {
        $track_path = Releases::getTrackName($track);
        $bits       = explode("/", $track_path[0]->meta_value);
        return end($bits);
    }

}
