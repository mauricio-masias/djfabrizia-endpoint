<?php

namespace App\Services;

use App\Models\Post;
use App\Helpers\FilterPostMeta as FilterHelper;
use App\Helpers\LinkTreeAppandWebUrls as UrlHelper;
use App\Helpers\LinkTreeImage as ImageHelper;
use App\Services\SocialService as Social;

class LinkTreeService
{
    public static function shapeResponse($metadata): array
    {
        $settings = FilterHelper::filterMetaDataWithKeys($metadata, '/\blinkt_/');

        $section[0] = [
            'hero_image'     => ImageHelper::getHeroImage((int)$settings['linkt_top_image']),
            'title'          => $settings['linkt_top_title'],
            'teaser'         => $settings['linkt_top_teaser'],
            'total_sections' => (int) $settings['linkt_sections'],
            'sections'       => self::sectionBuilder($settings),
            'page_bg'        => $settings['linkt_page_background'] ?: '#000000',
            'font_color'     => $settings['linkt_font_color'] ?: '#FFFFFF',
            'font_position'  => unserialize($settings['linkt_font_position'])[0],
            'status'         => true,
        ];

        return $section;
    }

    private static function sectionBuilder($settings): array 
    {
        $result = [];
        $totalSections = (int) $settings['linkt_sections'];
        $socialUrls = self::getSocialUrls();

        for($x = 0; $x < $totalSections; $x++) {
            $sectionId = (int) $settings['linkt_sections_' . $x . '_section_id'];
            
            $result[] = [
                'label' => $settings['linkt_sections_' . $x . '_section_label'],
                'links' => self::linkBuilder($settings, $sectionId, $socialUrls),
            ];
        }

        return $result;
    }

    private static function linkBuilder($settings, $sectionId, $socialUrls): array 
    {
        $result = [];
        $links = $settings['linkt_linktree'];

        for ($x = 0; $x < $links; $x++) {       
            $sections = unserialize($settings['linkt_linktree_' . $x . '_link_section']);
                    
            if (!in_array($sectionId, $sections)) {
                continue;
            }
            
            $result[] = [
                'description' => $settings['linkt_linktree_' . $x . '_link_description'] ?: $media,
                'image'       => ImageHelper::getLinkImage($settings, $x),  
                'url'         => UrlHelper::get($settings, $socialUrls, $x),
            ];
        }

        return $result;
    }

    private static function getSocialUrls(): array
    {
        $metadata = Post::getPostMeta(967);
        $settings = FilterHelper::filterMetaDataWithKeys($metadata, '/\bsocial_/');
        return Social::socialIcons($settings);
    } 
}
