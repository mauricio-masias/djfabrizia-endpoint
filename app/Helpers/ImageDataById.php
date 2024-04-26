<?php

namespace App\Helpers;
use App\Models\Post as Helper;

class ImageDataById
{
    public static function getImagePath(int $imageId): string
    {
    	$imageData = Helper::getPostMetaByMetaKey($imageId, '_wp_attached_file');
        return $imageData[0]->meta_value;
    }

    public static function getImageMeta(int $imageId): string
    {
        $imageData = Helper::getPostMetaByMetaKey($imageId, '_wp_attachment_metadata');
        return $imageData[0]->meta_value; 
    }

    public static function getAll(int $imageId): array
    {
        $imageData = Helper::getPostMeta($imageId);
        return self::shapeData($imageData); 
    }

    // todo add width, height, thumb
    private static function shapeData(object $data): array 
    {
    	$result  = [
    		'path' => null,
    		'alt' => null,
    	];

    	foreach($data as $row){
    		if ($row->meta_key === '_wp_attached_file'){
    			$result['path'] = $row->meta_value;
    		}
    		if ($row->meta_key === '_wp_attachment_image_alt') {
    			$result['alt'] = $row->meta_value;
    		}
    	}

    	return $result;
    }
}