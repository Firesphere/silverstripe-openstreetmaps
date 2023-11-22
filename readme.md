# Moved to codeberg

https://codeberg.org/Firesphere/silverstripe-openstreetmaps

# Openstreetmaps for Silverstripe

[GPL v3 or later](LICENSE.md)

Usage:

```dotenv
MAPBOX_TOKEN=MyMapboxTokenSecret
```

Static image:

```php
        /** @var Location $location */
        $location = Location::get()->last();

        $service = new OpenStreetmapService();
        $image = $service->getStaticMapImage($location, 500, 500, 15);
        echo $image->forTemplate();
        exit;

```

The following will add a map to a div on your page with id `map`.

If the div doesn't exist, things will break ;)

```php
        Requirements::javascript('firesphere/openstreetmaps:dist/js/main.js');
        Requirements::css('firesphere/openstreetmaps:dist/css/main.css');
        $token = Environment::getEnv('MAPBOX_TOKEN');
        Requirements::insertHeadTags(
            <<<JS
<script type="text/javascript">var mapboxtoken = "$token";</script>
JS
        );
        $service = new OpenStreetmapService();
        $locations = Location::get();
        if ($locations->exists()) {
            $service->addLocations($locations->sort('Primary DESC'));
        }

```

# Did you read this entire readme? You rock!

Pictured below is a cow, just for you.

```
               /( ,,,,, )\
              _\,;;;;;;;,/_
           .-"; ;;;;;;;;; ;"-.
           '.__/`_ / \ _`\__.'
              | (')| |(') |
              | .--' '--. |
              |/ o     o \|
              |           |
             / \ _..=.._ / \
            /:. '._____.'   \
           ;::'    / \      .;
           |     _|_ _|_   ::|
         .-|     '==o=='    '|-.
        /  |  . /       \    |  \
        |  | ::|         |   | .|
        |  (  ')         (.  )::|
        |: |   |;  U U  ;|:: | `|
        |' |   | \ U U / |'  |  |
        ##V|   |_/`"""`\_|   |V##
           ##V##         ##V##
```
