<?php
namespace Rjsmelo\Fiware\Poi\Test\Unit\Entity;

use Rjsmelo\Fiware\Poi\Entity\Poi;

class PoiTest extends \PHPUnit_Framework_TestCase
{
    private $uid  = 'ae01d34a-d0c1-4134-9107-71814b4805af';
    private $data = '{"fw_core":{"location":{"wgs84":{"latitude":1,"longitude":1}},"last_update":{"timestamp":1390985438},"category":"test_poi","name":{"":"Test POI 1"}}}';

    private $poi;

    public function setUp()
    {
        $uid = 'ae01d34a-d0c1-4134-9107-71814b4805af';
        $data = '{"fw_core":{"location":{"wgs84":{"latitude":1,"longitude":1}},"last_update":{"timestamp":1390985438},"category":"test_poi","name":{"":"Test POI 1"}}}';

        $this->poi = new Poi($uid, json_decode($data, true));
    }

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
        $this->assertEquals($this->uid, $this->poi->getId());
        $this->assertJsonStringEqualsJsonString($this->data, json_encode($this->poi->asArray()));
    }

    /**
     * @test
     */
    public function getComponents()
    {
        $components = $this->poi->components();

        $this->assertTrue(is_array($components));
        $this->assertCount(1, $components);
        $this->assertEquals('fw_core', $components[0]);
    }

    /**
     * @test
     */
    public function checkComponent()
    {
        $this->assertTrue($this->poi->has('fw_core'));
        $this->assertFalse($this->poi->has('fw_core_xxxx'));
    }
}
