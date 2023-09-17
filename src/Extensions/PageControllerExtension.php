<?php

namespace Firesphere\OpenStreetmaps\Extensions;

use PageController;
use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\OpenStreetmaps\Extensions\PageControllerExtension
 *
 * @property PageController|PageControllerExtension $owner
 */
class PageControllerExtension extends Extension
{
    public static $db_to_js_map = [
        'DefaultZoom' => 'zoom',
        'Container'   => 'container',
        'MaxZoom'     => 'maxZoom'
    ];

    public function onAfterInit()
    {
        /** @var SiteConfig|SiteConfigExtension $sc */
        $sc = SiteConfig::current_site_config();
        if ($this->owner->dataRecord->HasMap || $sc->GlobalMap) {
            $config = [
                'style' => 'mapbox://styles/' . $sc->Style,
            ];
            foreach (self::$db_to_js_map as $key => $jsKey) {
                $config[$jsKey] = $sc->$key;
            }
            $config['center'] = [$sc->CenterLng, $sc->CenterLat];
            $cfg = json_encode($config);

            $tmpl = str_replace([PHP_EOL, "\r", "\n"], '', $sc->PopupTemplate ?? '<div></div>');
            Requirements::insertHeadTags(
                <<<MAPCONFIG
<script type="text/javascript">
var mapConfig = $cfg;
var popupTemplate = "$tmpl";
</script>
MAPCONFIG
            );
        }
    }
}
