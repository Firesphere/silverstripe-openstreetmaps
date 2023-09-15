<?php

namespace Firesphere\OpenStreetmaps\Models;

use Firesphere\OpenStreetmaps\Forms\MapboxField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Subsites\Model\Subsite;

/**
 * Class \Firesphere\OpenStreetmaps\Models\Location
 *
 * @property bool $Primary
 * @property string $Name
 * @property string $Address
 * @property string $City
 * @property string $Country
 * @property string $URL
 * @property string $Description
 * @property string $Latitude
 * @property string $Longitude
 * @method DataList|StaticImage[] StaticImages()
 */
class Location extends DataObject
{
    private static $table_name = 'Location';

    private static $db = [
        'Name'        => DBVarchar::class,
        'Address'     => DBVarchar::class,
        'City'        => DBVarchar::class,
        'Country'     => DBVarchar::class,
        'URL'         => DBVarchar::class,
        'Description' => DBHTMLText::class,
        'Latitude'    => DBVarchar::class,
        'Longitude'   => DBVarchar::class,
    ];

    private static $has_one = [
    ];

    private static $has_many = [
        'StaticImages' => StaticImage::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['Latitude', 'Longitude', 'City', 'Country']);
        $mapboxField = MapboxField::create('Address', 'Address');
        $mapboxField->setLocationObject($this);
        $fields->addFieldToTab('Root.Main', $mapboxField, 'Description');

        return $fields;
    }
}
