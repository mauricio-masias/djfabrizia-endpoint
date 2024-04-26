<?php

namespace App\Services;

use App\Helpers\FilterPostMeta as Helper;

class SocialService
{
    public static function shapeResponse($metadata): array
    {
        $settings = Helper::filterMetaDataWithKeys($metadata, '/\bsocial_/');

        $section[0] = [
            'title'   => $settings['social_title'],
            'content' => self::socialContent($settings),
            'status'  => true,
        ];

        return $section;
    }

    private static function socialContent($settings): array
    {
        return [
            'above_icons'    => $settings['social_aboveicons'],
            'below_icons'    => $settings['social_belowicons'],
            'subscribe_text' => $settings['social_subscribe'],
            'follow_text'    => $settings['social_follow'],
            'ad_link'        => $settings['social_ad_link'],
            'ad_img'         => $settings['social_ad_img'],
            'ad_alt'         => $settings['social_ad_alt'],
            'yt_id'          => $settings['social_yt_channel'],
            'facebook_id'    => $settings['social_facebook_id'],
            'twitter_id'     => $settings['social_twitter_id'],
            'twitter_limit'  => $settings['social_twitter_limit'],
            'icons'          => self::socialIcons($settings),
        ];
    }

    public static function socialIcons($settings): array
    {
        $icons    = [];
        $filtered = [];

        foreach ($settings as $key => $string) {
            if (strpos($key, 'social_icons_') !== false) {
                $icons[$key] = $string;
            }
        }

        for ($x = 0; $x < (int) $settings['social_icons']; $x++) {
            $filtered[] = [
                'name'    => $icons['social_icons_' . $x . '_icon_network'],
                'class'   => $icons['social_icons_' . $x . '_icon_class'],
                'url'     => $icons['social_icons_' . $x . '_icon_link'],
                'type'    => $icons['social_icons_' . $x . '_icon_type'],
                'app_url' => array_key_exists('social_icons_' . $x . '_icon_app_link', $icons) 
                    ? $icons['social_icons_' . $x . '_icon_app_link']
                    : null,
            ];
        }

        return $filtered;
    }

}
