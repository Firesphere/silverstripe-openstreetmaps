<?php

namespace Firesphere\OpenStreetmaps\Services;

use Firesphere\OpenStreetmaps\Models\Location;
use Firesphere\OpenStreetmaps\Models\StaticImage;
use Intervention\Image\Exception\NotFoundException;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ValidationException;
use SilverStripe\View\Requirements;

class OpenStreetmapService
{
    use Configurable;

    /**
     * API endpoint for static maps
     * Full URL Format:
     * [
     *  https
     *  URI
     *  styles
     *  v1
     *  {@config self::config()->get('static')['style'];
     *  static
     *  latitude
     *  longitude
     *  {@config self::config()->get('static')['width']
     *  {@config self::config()->get('static')['height']
     * ]
     * get params: Environment::getEnv('MAPBOX_TOKEN');
     * @var string
     */
    protected static $mapbox_url = 'https://api.mapbox.com/styles/v1/%s/static/%s,%s,%s,0/%sx%s?access_token=%s';

    /**
     * Fetches a generated static image from Mapbox, and stores it locally
     * to avoid potential slow responses or key exhaustion.
     * @param Location $location
     * @param int $width
     * @param int $height
     * @param int $zoom
     * @return Image
     * @throws ValidationException
     */
    public function getStaticMapImage(Location $location, int $width = 0, int $height = 0, int $zoom = 0): Image
    {
        $key = Environment::getEnv('MAPBOX_TOKEN');
        $conf = self::config()->get('static');
        if (!$width || !$height) {
            $width = $conf['width'];
            $height = $conf['height'];
        }
        if (!$zoom) {
            $zoom = $conf['zoom'] ?? 9;
        }

        // MD5 is a "strong" enough algorithm to generate some sort of unique hash.
        $hash = hash('md5', $conf['style'] . $location->Longitude . $location->Latitude . $width . $height . $zoom);


        /** @var StaticImage|null $exists */
        $exists = StaticImage::get()
            ->filter([
                'Hash'       => $hash,
                'LocationID' => $location->ID
            ])
            ->first();

        if ($exists && $exists->MapboxImage()->exists()) {
            return $exists->MapboxImage();
        }
        $url = sprintf(static::$mapbox_url, $conf['style'], $location->Longitude, $location->Latitude, $zoom, $width, $height, $key);


        $content = file_get_contents($url);

        if (!$content) {
            throw new NotFoundException('Could not download image');
        }
        $image = Image::create();
        $image->Title = $location->Name;
        $filename = SiteTree::singleton()->generateURLSegment($location->Name);
        $image->setFromString($content, $filename . '.png');
        $image->publishFile();
        $imageId = $image->write();
        $keylessURL = explode('?', $url);
        $static = StaticImage::create([
            'Hash'          => $hash,
            'URL'           => $keylessURL[0],
            'MapboxImageID' => $imageId,
            'LocationID'    => $location->ID
        ]);
        $static->write();

        return $image;
    }

    /**
     * Put the list of locations in to the <head> element.
     * @param DataList|ArrayList $list
     * @return void
     */
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
