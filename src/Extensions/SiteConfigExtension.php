<?php

namespace Firesphere\OpenStreetmaps\Extensions;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBDecimal;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class \Firesphere\OpenStreetmaps\Extensions\SiteConfigExtension
 *
 * @property SiteConfig|SiteConfigExtension $owner
 * @property int $DefaultZoom
 * @property bool $GlobalMap
 * @property string $Container
 * @property string $Style
 * @property float $CenterLat
 * @property float $CenterLng
 * @property int $MaxZoom
 * @property string $PopupTemplate
 */
class SiteConfigExtension extends DataExtension
{
    protected static $map_styles = [
        'mapbox/streets-v12'           => 'Mapbox Streets',
        'mapbox/light-v11'             => 'Mapbox Light',
        'mapbox/dark-v11'              => 'Mapbox Dark',
        'mapbox/outdoors-v12'          => 'Mapbox Outdoors',
        'mapbox/satellite-v9'          => 'Mapbox Satellite',
        'mapbox/satellite-streets-v12' => 'Mapbox Satellite Streets'
    ];
    private static $db = [
        'DefaultZoom'   => DBInt::class,
        'GlobalMap'     => DBBoolean::class,
        'Container'     => DBVarchar::class,
        'Style'         => DBVarchar::class,
        'CenterLat'     => DBDecimal::class . '(16,12)',
        'CenterLng'     => DBDecimal::class . '(16,12)',
        'MaxZoom'       => DBInt::class,
        'PopupTemplate' => DBText::class,
    ];
    private static $defaults = [
        'DefaultZoom' => 10,
        'GlobalMap'   => false,
        'Container'   => 'map',
        'Style'       => 'mapbox/streets-v12',
        'CenterLat'   => '0.0',
        'CenterLng'   => '0.0',
        'MaxZoom'     => 18
    ];

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        $fields->addFieldsToTab(
            'Root.OpenStreetMaps',
            [
                CheckboxField::create('GlobalMap', 'Show the map on every page'),
                NumericField::create('DefaultZoom', 'Starting zoom level'),
                TextField::create('Container', 'ID of the container div'),
                DropdownField::create('Style', 'Map style', static::$map_styles),
                NumericField::create('CenterLat', 'Center Latitude')->setScale(12),
                NumericField::create('CenterLng', 'Center Longitude')->setScale(12),
                NumericField::create('MaxZoom', 'Maximum zoom level'),
                TextareaField::create('PopupTemplate', 'Flat HTML to display as template')
            ]
        );
    }
}
