<?php
namespace Rjsmelo\Fiware\Poi\Test\Unit\Response;

use Rjsmelo\Fiware\Poi\Response\PoiList;

class PoiListTest extends \PHPUnit_Framework_TestCase
{
    const SAMPLE = '{"pois":{"ae01d34a-d0c1-4134-9107-71814b4805af":{"fw_core":{"location":{"wgs84":{"latitude":1,"longitude":1}},"category":"test_poi","name":{"":"Test POI 1"}}}}}';

    /**
     * @test
     */
    public function createObject()
    {
        $json = json_decode(self::SAMPLE);
        $poiList = new PoiList($json);

        $this->assertInstanceOf('Rjsmelo\Fiware\Poi\Response\PoiList', $poiList);
    }

    /**
     * @test
     */
    public function checkForPoi()
    {
        $json = json_decode(self::SAMPLE);
        $poiList = new PoiList($json);

        $poiListAsArray = $poiList->asArray();

        $this->assertCount(1, $poiListAsArray);
        $this->assertArrayHasKey('ae01d34a-d0c1-4134-9107-71814b4805af', $poiListAsArray);
    }
}
