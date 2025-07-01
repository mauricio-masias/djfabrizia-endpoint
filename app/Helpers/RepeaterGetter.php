<?php

namespace App\Helpers;

use App\Models\Post;

class RepeaterGetter
{
    // repeater stores the label as total e.g. itemLabel = 8
    // then iterates from 0.  if same name sub items from 1:  itemLabel_0_nameSubItem_1
    public static function getSingleRepeater($payload, $needle, $itemLabel): array
    {
        $content      = [];
        $totalRepeats = (int) $payload[$needle];

        for ($x = 0; $x < $totalRepeats; $x++) {
            $content[] = $payload[ $needle . '_' . $x . '_' . $itemLabel[0] ];
        }
        return $content;
    }

    public static function getCarouselUrls($serialized): array
    {
        $content = [];
        $imgIds = unserialize($serialized);

        for ($x = 0; $x < count($imgIds); $x++) {
            $content[] = Post::getPostMeta($imgIds[$x])[0]->meta_value;
        }
        return $content;
    }

    public static function getVideoRepeater($payload, $needle, $itemLabel): array
    {
        $content      = [];
        $totalRepeats = (int) $payload[$needle];

        for ($x = 0; $x < $totalRepeats; $x++) {
            $bits = [];
            for ($y = 1; $y <= count($itemLabel); $y++) {
                $value = $payload[ $needle . '_' . $x . '_' . $itemLabel[$y-1] ];
                switch ($itemLabel[$y-1]) {
                    case 'label' : $bits['label'] = $value; break;
                    case 'alt_text' : $bits['alt'] = $value; break;
                    case 'url': $bits['url'] = $value; break;
                    case 'image': $bits['img'] = Post::getPostMeta($value)[0]->meta_value; break;
                    default: break;
                }
            }
            $content[] = $bits;
        }
        return $content;
    }

    public static function getMixRepeater($payload, $needle, $itemLabel): array
    {
        $content      = [];
        $totalRepeats = (int) $payload[$needle];

        for ($x = 0; $x < $totalRepeats; $x++) {
            $bits = [];
            for ($y = 1; $y <= count($itemLabel); $y++) {
                $value = $payload[ $needle . '_' . $x . '_' . $itemLabel[$y-1] ];
                
                if ($itemLabel[$y-1] === 'mix') {   
                    $bits['url'] = Post::getPostMeta($value)[0]->meta_value;
                    $bits['img'] = Post::getPostMeta($value)[2]->meta_value;
                } else {
                    $bits['label'] = $value;
                }
                
            }
            $content[] = $bits;
        }
        return $content;
    }
}
