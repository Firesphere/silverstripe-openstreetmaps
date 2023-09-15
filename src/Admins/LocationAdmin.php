<?php

namespace Firesphere\OpenStreetmaps\Admins;

use Firesphere\OpenStreetmaps\Models\Location;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \Firesphere\Wedding\Admins\LocationAdmin
 *
 */
class LocationAdmin extends ModelAdmin
{
    private static $managed_models = [
        Location::class
    ];

    private static $menu_title = 'Locations';

    private static $url_segment = 'locations';

    private static $menu_icon_class = 'font-icon-p-map';
}
