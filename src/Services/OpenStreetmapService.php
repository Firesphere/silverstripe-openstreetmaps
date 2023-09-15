<?php

namespace Firesphere\OpenStreetmaps\Services;

use Firesphere\OpenStreetmaps\Models\Location;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\View\Requirements;

class OpenStreetmapService
{
    use Configurable;

    public function getMapImage(Location $location)
    {

    }

    public function addLocations(DataList|ArrayList $list)
    {
        $data = [];
        /** @var Location $location */
        foreach ($list as $location) {
            $data[] = [
                [$location->Longitude, $location->Latitude],
                $location->Name,
                $location->Address,
                $location->Description ?? '',
                $location->URL
            ];
        }
        $data = json_encode($data);
        Requirements::insertHeadTags("<script type='text/javascript'>
var locations = $data;
</script>");
    }

    public function getMapLocation(Location $location)
    {
        Requirements::insertHeadTags("<script type='text/javascript'>
var coords = [['$location->Longitude', '$location->Latitude']];
</script>");
    }
}
