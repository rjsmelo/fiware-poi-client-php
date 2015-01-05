<?php
namespace Rjsmelo\Fiware\Poi\Test\Unit\Entity;

use Rjsmelo\Fiware\Poi\Entity\Poi;

class PoiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createEmptyPoi()
    {
        $poi = new Poi();

        $this->assertNull($poi->getId());
        $this->assertTrue(is_array($poi->asArray()));
        $this->assertCount(0, $poi->asArray());
    }

    /**
     * @test
     */
    public function createPoi()
    {
        $uid = 'ae01d34a-d0c1-4134-9107-71814b4805af';
        $data = '{"fw_core":{"location":{"wgs84":{"latitude":1,"longitude":1}},"last_update":{"timestamp":1390985438},"category":"test_poi","name":{"":"Test POI 1"}}}';

        $poi = new Poi($uid, json_decode($data, true));

        $this->assertEquals($uid, $poi->getId());
        $this->assertJsonStringEqualsJsonString($data, json_encode($poi->asArray()));
    }
}
