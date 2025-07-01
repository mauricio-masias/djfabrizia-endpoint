<?php

namespace App\Services;

use App\Helpers\RepeaterGetter as Looper;
use App\Helpers\FilterPostMeta as Helper;

class EpkService
{
    public static function shapeResponse($metadata): array
    {
        $sIntro = Helper::filterMetaDataWithKeys($metadata, '/\bintro_/');
        $sAbout = Helper::filterMetaDataWithKeys($metadata, '/\babout_/');
        $sWhatOffers = Helper::filterMetaDataWithKeys($metadata, '/\bwhatOffers_/');
        $sVideos = Helper::filterMetaDataWithKeys($metadata, '/\bvideos_/');
        $sMixes = Helper::filterMetaDataWithKeys($metadata, '/\bmixes/');

        return [
            'intro'      => self::introContent($sIntro),
            'about'      => self::aboutContent($sAbout),
            'whatOffers' => self::offersContent($sWhatOffers),
            'videos'     => self::videosContent($sVideos),
            'mixes'      => self::mixesContent($sMixes),
            'status'     => true,
        ];
    }

    private static function introContent($sIntro): array
    {
        return [
            'insta_stats_img' => Looper::getImageUrl($sIntro['intro_insta_stats']),
            'insta_stats_alt' => $sIntro['intro_insta_stats_alt'],
            'email_label'     => $sIntro['intro_email_label'],
            'email_text'      => $sIntro['intro_email_text'],
            'whatsapp_label'  => $sIntro['intro_whatsapp_label'],
            'whatsapp_text'   => $sIntro['intro_whatsapp_text'],
            'socials_label'   => $sIntro['intro_socials_label'],
            'socials_text'    => $sIntro['intro_socials_text'],
            'website_label'   => $sIntro['intro_website_label']
        ];
    }

    private static function aboutContent($sAbout): array
    {
        return [
            'reel_url'             => $sAbout['about_reel_url'],
            'reel_image'           => Looper::getImageUrl($sAbout['about_reel_image']),
            'reel_cta'             => $sAbout['about_reel_cta'],
            'reel_title'           => $sAbout['about_reel_title'],
            'intro_a'              => $sAbout['about_intro_a'],
            'intro_b'              => $sAbout['about_intro_b'],
            'carousel'             => Looper::getCarouselUrls($sAbout['about_carousel']),
            'ideal_title'          => $sAbout['about_ideal_title'],
            'ideal_reasons'        => Looper::getSingleRepeater(
                                        $sAbout, 
                                        'about_ideal_reasons', 
                                        ['reason']
                                      ),
            'tailored_title'       => $sAbout['about_tailored_title'],
            'tailored_text'        => $sAbout['about_tailored_text'],
            'renowed_title'        => $sAbout['about_renowed_title'],
            'renowed_text'         => $sAbout['about_renowed_text'],
            'renowed_text_b'       => $sAbout['about_renowed_text_b'],
            'worldwide_title'      => $sAbout['about_worldwide_title'],
            'worldwide_text'       => $sAbout['about_worldwide_text'],
            'worldwide_link_label' => $sAbout['about_worldwide_link_label'],
            'worldwide_link_url'   => $sAbout['about_worldwide_link_url'],
            'collaboration_title'  => $sAbout['about_collaboration_title'],
            'collaboration_text'   => $sAbout['about_collaboration_text'],
            'collaboration_text_b' => $sAbout['about_collaboration_text_b']
        ];
    }

    private static function offersContent($sWhatOffers): array
    {
        return [
            'title'         => $sWhatOffers['whatOffers_title'],
            'offer1'        => $sWhatOffers['whatOffers_offer1'],
            'offer1_text'   => $sWhatOffers['whatOffers_offer1_text'],
            'offer2'        => $sWhatOffers['whatOffers_offer2'],
            'offer2_text'   => $sWhatOffers['whatOffers_offer2_text'],
            'offer3'        => $sWhatOffers['whatOffers_offer3'],
            'offer3_text'   => $sWhatOffers['whatOffers_offer3_text'],
            'offer4'        => $sWhatOffers['whatOffers_offer4'],
            'offer4_text'   => $sWhatOffers['whatOffers_offer4_text'],
            'offer5'        => $sWhatOffers['whatOffers_offer5'],
            'offer5_text'   => $sWhatOffers['whatOffers_offer5_text'],
            'offer5_text_b' => $sWhatOffers['whatOffers_offer5_text_b'],
            'offer6'        => $sWhatOffers['whatOffers_offer6'],
            'offer6_text'   => $sWhatOffers['whatOffers_offer6_text'],
            'setup_cta'     => $sWhatOffers['whatOffers_setup_cta'],
            'setup_url'     => $sWhatOffers['whatOffers_setup_url'],
            'setup_alt'     => $sWhatOffers['whatOffers_setup_alt'],
            'listen_here_1' => $sWhatOffers['whatOffers_listen_here_1'],
            'listen_here_2' => $sWhatOffers['whatOffers_listen_here_2'],
            'songs_by'      => $sWhatOffers['whatOffers_songs_by']
        ];
    }

    private static function videosContent($sVideos): array
    {
        return [
            'insta_stats'      => $sVideos['videos_corporate_title'],
            'email_label'      => $sVideos['videos_underground_title'],
            'videos_corporate' => Looper::getVideoRepeater(
                                    $sVideos,
                                    'videos_corporate',
                                    ['label', 'alt_text', 'url', 'image']
                                  ),
            'videos_undergound' => Looper::getVideoRepeater(
                                    $sVideos,
                                    'videos_undergound',
                                    ['label', 'alt_text', 'url', 'image']
                                  )
        ];
    }

    private static function mixesContent($sMixes): array
    {
        return [
            'title' => $sMixes['mixes_title'],
            'mixes' => Looper::getMixRepeater(
                            $sMixes,
                            'mixes',
                            ['label', 'mix']
                        )
        ];
    }


}
