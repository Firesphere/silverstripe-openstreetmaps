<?php

namespace Firesphere\OpenStreetmaps\Extensions;

use Page;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBBoolean;

/**
 * Class \Firesphere\OpenStreetmaps\Extensions\PageExtension
 *
 * @property Page|PageExtension $owner
 * @property bool $HasMap
 */
class PageExtension extends DataExtension
{
    private static $db = [
        'HasMap' => DBBoolean::class . '(false)'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);
        $fields->addFieldToTab(
            'Root.OpenStreetmaps',
            CheckboxField::create('HasMap', 'This page should show a map')
                ->setDescription('This is ignored if the Global setting is checked in the Settings')
        );
    }
}
