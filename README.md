# fiware-poi-client-php


PHP Client Library for POI Data Provider Open API Specification

## Quick Example

```php
<?php
require 'vendor/autoload.php';

use Rjsmelo\Fiware\Poi\Client;
use Rjsmelo\Fiware\Poi\Query\PoiListQuery;

$client = new Client('http://localhost:8080');

$poiListSearch = new PoiListQuery('ae01d34a-d0c1-4134-9107-71814b4805af');
$poiList = $client->getPoiList($poiListSearch);
```
