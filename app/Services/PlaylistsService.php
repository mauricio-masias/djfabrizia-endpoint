<?php

namespace App\Services;
use App\Helpers\FilterPostMeta as Helper;
use App\Helpers\Paginate as PaginateHelp;
use App\Models\Playlists;

class PlaylistsService
{
    public static function shapeResponse( $metadata, $page = 1 ) : array
    {
        $settings      = Helper::filterMetaDataWithKeys( $metadata,  '/\bplaylists_/' );
        $raw_playlists = Playlists::getRange( $settings['playlists_paginate'], $page );
        $tracks        = self::shapeTracks( $raw_playlists );
        $total_tracks  = Playlists::countAll();

        $button_status = PaginateHelp::buttonStatus( $total_tracks, $page, $settings['playlists_paginate'] );
        $total_pages   = PaginateHelp::totalPages( $total_tracks, $settings['playlists_paginate'] );

        $section[0] = [
            'title'   => $settings['playlists_title'],
            'content' => [
                'status' => true,
                'tracks' => $tracks,
                'more_button' => [
                    'next_page'    => ( (int)$page + 1 ),
                    'current_page' => (int)$page,
                    'total_pages'  => $total_pages,
                    'label'        => $settings['playlists_more_button'],
                    'active'       => $button_status,
                ]
            ],
        ];

        return $section;
    }

    private static function shapeTracks( $playlists )
    {
        $result = [];
        if ( count( $playlists ) > 0 ) {

            foreach ( $playlists as $playlist ) {

                $result[] = [
                    'name' 	       => $playlist->short_name,
                    'url' 	       => $playlist->url,
                    'img' 		   => $playlist->image,
                    'artist_url'   => $playlist->artist_url,
                    'total_tracks' => $playlist->total_tracks,
                ];
            }

        }
        return $result;
    }


}
