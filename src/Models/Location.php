<?php

namespace Firesphere\OpenStreetmaps\Models;

use Firesphere\OpenStreetmaps\Forms\MapboxField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Subsites\Model\Subsite;

/**
 * Class \Firesphere\OpenStreetmaps\Models\Location
 *
 * @property bool $Primary
 * @property string $MapboxStyle
 * @property string $Name
 * @property string $Address
 * @property string $Country
 * @property string $Description
 * @property string $GoogleMapsLatField
 * @property string $GoogleMapsLngField
 * @property int $SiteID
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
