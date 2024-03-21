<?php

namespace App\Services;

class NavigationService
{
    public static function setCustomValues($default_rows): array
    {
        $menuItems = [];

        foreach ($default_rows as $key => $menu_item) {
            // set internal or external links
            $internal = !($menu_item->target == '_blank');

            if ($internal) {
                $url    = explode("/#", str_replace("http://", "", $menu_item->url));
                $url[1] = (count($url) < 2) ? '' : '#' . $url[1];
            } else {
                //if external link start with "//"" then remove it (used for mobile app openings)
                $url[0] = substr($menu_item->url, 0, 2) === "//" ? substr($menu_item->url, 2) : $menu_item->url;
                $url[1] = '';
            }

            if ($menu_item->url == '#') {
                $internal = 'none';
            }

            // set icons for social links
            $is_icon     = substr($menu_item->title, 0, 5) == 'icon-';
            $social_icon = substr($menu_item->title, 5);

            array_push(
                $menuItems, [
                    'id'       => $menu_item->ID,
                    'title'    => $menu_item->title,
                    'url'      => $url[0],
                    'hash'     => $url[1],
                    'internal' => $internal,
                    'parent'   => $menu_item->parent,
                    'is_icon'  => $is_icon,
                    'icon'     => $social_icon,
                ]
            );
        }

        return $menuItems;
    }
}
