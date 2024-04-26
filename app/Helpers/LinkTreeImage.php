<?php

namespace App\Helpers;

use App\Helpers\ImageDataById as ImageHelper;

class LinkTreeImage
{
	public static $mediaCdnUrls = [
		'instagram' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/132px-Instagram_logo_2016.svg.png',
		'facebook'  => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Facebook_F_icon.svg/512px-Facebook_F_icon.svg.png',
		'x'  => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cc/X_icon.svg/800px-X_icon.svg.png?20230813175046',
		'youtube' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/YouTube_play_button_icon_%282013%E2%80%932017%29.svg/1024px-YouTube_play_button_icon_%282013%E2%80%932017%29.svg.png',
		'mixcloud' => 'https://pbs.twimg.com/profile_images/1626300650731470849/fmsVD4rY_400x400.jpg',
		'spotify' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Spotify_icon.svg/512px-Spotify_icon.svg.png'
	];

	public static function getLinkImage($settings, $index): array|null 
	{
		if (array_key_exists('linkt_linktree_' . $index . '_link_image', $settings)) {
			$image = ImageHelper::getAll((int)$settings['linkt_linktree_' . $index . '_link_image']);
        	return [ 
        		'type' => 'internal',
               	'path' => $image['path'], 
                'alt'  => $image['alt'], 
            ];
		}

		$media = strtolower($settings['linkt_linktree_' . $index . '_link_media']);

		if ($media === 'custom') {
			return null;
		}

		if (str_contains($media, '-custom')) {
			$media = str_replace('-custom', '', $media);
		}

		return [ 
        		'type' => 'external',
               	'path' => self::$mediaCdnUrls[$media], 
                'alt'  => ucfirst($media), 
        ];
	} 

	public static function getHeroImage(int $imageId): array|null
	{
		if ($imageId===0) {
			return null;
		}

		$image = ImageHelper::getAll($imageId);
        return [ 
        	'type' => 'internal',
            'path' => $image['path'], 
            'alt'  => $image['alt'], 
        ];
	}
}
