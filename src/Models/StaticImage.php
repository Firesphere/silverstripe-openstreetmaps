<?php

namespace Firesphere\OpenStreetmaps\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\OpenStreetmaps\Models\StaticImage
 *
 * @property string $Hash
 * @property string $URL
 * @property int $MapboxImageID
 * @property int $LocationID
 * @method Image MapboxImage()
 * @method Location Location()
 */
class StaticImage extends DataObject
{
    private static $table_name = 'StaticMapImage';
    
    private static $db = [
        'Hash' => DBVarchar::class,
        'URL'  => DBVarchar::class,
    ];

    private static $has_one = [
        'MapboxImage' => Image::class,
        'Location'    => Location::class
    ];

    private static $owns = [
        'MapboxImage'
    ];
}