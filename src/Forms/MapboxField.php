<?php

namespace Firesphere\OpenStreetmaps\Forms;

use Firesphere\OpenStreetmaps\Services\OpenStreetmapService;
use SilverStripe\Core\Environment;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class MapboxField extends TextField
{
    protected $locationObject;

    protected $accessToken;

    public function getLocationObject(): mixed
    {
        return $this->locationObject;
    }

    public function setLocationObject(mixed $locationObject): self
    {
        $this->locationObject = $locationObject;

        return $this;
    }
    private static $record_fields = [
        'Address',
        'City',
        'Country',
        'Latitude',
        'Longitude'
    ];

    public function __construct($name, $title = null, $value = '', $maxLength = null, $form = null, $object = null)
    {
        $this->accessToken = Environment::getEnv('MAPBOX_TOKEN');
        $config = OpenStreetmapService::config()->get('config');
        if (!empty($config)) {
            $config = json_encode($config);
            Requirements::insertHeadTags(<<<MAPBOX
<script type="text/javascript">
var OSMConfig = $config;
</script>
MAPBOX);
        }

        Requirements::javascript('firesphere/openstreetmaps:dist/js/formfield.js');

        $this->locationObject = $object;

        parent::__construct($name, $title, $value, $maxLength, $form);

        $this->addExtraClass('text');
    }

    public function getHiddenFields()
    {
        $content = "<div id='$this->name' class='AddressInputDiv'></div>";
        foreach (self::$record_fields as $field) {
            $formfield = HiddenField::create($field, '')->addExtraClass($field . '_input');
            if ($this->locationObject) {
                $formfield->setValue($this->locationObject->$field);
            }
            $content .= $formfield->forTemplate();
        }

        return $content;
    }
    public function forTemplate()
    {
        return parent::forTemplate();
    }
}
