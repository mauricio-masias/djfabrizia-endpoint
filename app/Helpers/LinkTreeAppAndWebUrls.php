<?php

namespace App\Helpers;

class LinkTreeAppAndWebUrls
{
	public static function get(array $settings, array $socialUrls, int $index): array 
    {
        $media = strtolower($settings['linkt_linktree_' . $index . '_link_media']);
        $url = array_key_exists('linkt_linktree_' . $index . '_link_url', $settings) 
                ? $settings['linkt_linktree_' . $index . '_link_url']  
                : null;

        // When full custom, use Url as provided
        if ($media === 'custom') {
            return [
                'web' => $url,
                'app' => $url
            ];
        }

        // When -custom, replace the user ID on the default social link
        if (str_contains($media, '-custom')) {
            $baseMedia = str_replace("-custom", "", $media);

            foreach ($socialUrls as $social) {
                if (strtolower($social['name']) === $baseMedia) {
                    return [ 
                        'web' => is_null($social['url']) 
                                    ? null 
                                    : self::swapUserId($social['url'], $url), 
                        'app' => is_null($social['app_url']) 
                                    ? null 
                                    : self::swapUserId($social['app_url'], $url),
                    ];
                }
            }
        }

        // when media is selected use the socialUrls
        foreach ($socialUrls as $social) {
            if (strtolower($social['name']) === $media) {
                return [ 
                    'web' => $social['url'], 
                    'app' => $social['app_url'],
                ];
            }
        }

        return [];
    }

    private static function swapUserId(string $socialUrl, string $url): string
    {
        // When id is after an "=""
        if (str_contains($socialUrl, '=')) {
            $path = explode("=", $socialUrl);
            $user = array_pop($path);
            return str_replace($user, $url, $socialUrl);
        }

        // When id is after an "/"
        $path = explode("/", $socialUrl);
        $user = array_pop($path);
        return str_replace($user, $url, $socialUrl);
    }
}