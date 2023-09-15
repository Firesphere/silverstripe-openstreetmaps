<?php

namespace Firesphere\OpenStreetmaps\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\OpenStreetmaps\Extensions\SiteConfigExtension
 *
 * @property SiteConfigExtension $owner
 * @property string $MapboxKey
 * @property int $DefaultZoom
 */
class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'DefaultZoom' => DBInt::class,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        $fields->addFieldsToTab(
            'Root.OpenStreetMaps',
            [
                NumericField::create('DefaultZoom', 'Start zoom level')
            ]
        );
    }
}
