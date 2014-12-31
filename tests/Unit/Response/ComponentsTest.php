<?php

namespace Rjsmelo\Fiware\Poi\Test\Unit\Response;

use Rjsmelo\Fiware\Poi\Response\Components;

class ComponentsTest extends \PHPUnit_Framework_TestCase {

    const ZERO_COMPONENTS = '{"components": []}';
    const MULTIPLE_COMPONENT = '{"components":["fw_core","fw_contact","fw_xml3d","fw_media","fw_time","fw_sensor","fw_marker","fw_relationships"]}';

    /**
     * @test
     */
    public function createObject()
    {
        $json = json_decode(self::MULTIPLE_COMPONENT);
        $components = new Components($json);

        $this->assertInstanceOf('Rjsmelo\Fiware\Poi\Response\Components', $components);
    }

    /**
     * @test
     */
    public function checkForComponent()
    {
        $json = json_decode(self::MULTIPLE_COMPONENT);
        $components = new Components($json);

        $this->assertTrue($components->has('fw_core'));
        $this->assertFalse($components->has('fw_core_xxxx'));
    }
}