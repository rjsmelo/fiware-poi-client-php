<?php
namespace Rjsmelo\Fiware\Poi\Test\Unit;

use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Subscriber\Mock;
use Rjsmelo\Fiware\Poi\Client;
use Rjsmelo\Fiware\Poi\Query\BoundingBoxQuery;
use Rjsmelo\Fiware\Poi\Query\PoiListQuery;
use Rjsmelo\Fiware\Poi\Server\PoiServer;
use Rjsmelo\Fiware\Poi\Query\RadialQuery;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PoiServer
     */
    private $server;

    /**
     * @var History
     */
    private $history;

    public function setUp()
    {
        $this->server = new PoiServer("http://localhost:8080");
        $this->history = new History();
        $this->server->getEmitter()->attach($this->history);
    }

    /**
     * @param $filename
     * @return Mock
     */
    private function getGuzzleMockResponse($filename)
    {
        $realFile = __DIR__.DIRECTORY_SEPARATOR.'Mock'.DIRECTORY_SEPARATOR.$filename;
        $content = file_get_contents($realFile);

        $mock = new Mock([$content]);

        return $mock;
    }

    /**
     * @test
     */
    public function getComponents()
    {
        $this->server->getEmitter()->attach($this->getGuzzleMockResponse('GetComponents'));
        $client = new Client($this->server);

        $components = $client->getComponents();
        $this->assertInstanceOf('Rjsmelo\Fiware\Poi\Response\Components', $components);
    }

    /**
     * @test
     */
    public function radialSearch()
    {
        $this->server->getEmitter()->attach($this->getGuzzleMockResponse('RadialSearch'));
        $client = new Client($this->server);

        $radialQuery = new RadialQuery(1, 1, null, 'test_poi');

        $poiList = $client->radialSearch($radialQuery);
        $this->assertInstanceOf('Rjsmelo\Fiware\Poi\Response\PoiList', $poiList);

        $query = $this->history->getLastRequest()->getQuery();
        $this->assertEquals(1, $query['lat']);
        $this->assertEquals(1, $query['lon']);
        $this->assertEquals('test_poi', $query['category']);
        $this->assertFalse($query->hasKey('radius'));
    }

    /**
     * @test
     */
    public function boundingBoxSearch()
    {
        $this->server->getEmitter()->attach($this->getGuzzleMockResponse('BoundingBoxSearch'));
        $client = new Client($this->server);

        $boundingBoxQuery = new BoundingBoxQuery(1, 0, 1, 0, 'test_poi');

        $poiList = $client->boundingBoxSearch($boundingBoxQuery);
        $this->assertInstanceOf('Rjsmelo\Fiware\Poi\Response\PoiList', $poiList);

        $query = $this->history->getLastRequest()->getQuery();
        $this->assertEquals(1, $query['north']);
        $this->assertEquals(0, $query['south']);
        $this->assertEquals(1, $query['east']);
        $this->assertEquals(0, $query['west']);
        $this->assertEquals('test_poi', $query['category']);
        $this->assertFalse($query->hasKey('maxResults'));
    }

    /**
     * @test
     */
    public function poiListSearch()
    {
        $this->server->getEmitter()->attach($this->getGuzzleMockResponse('PoiListSearch'));
        $client = new Client($this->server);

        $poiListSearch = new PoiListQuery('ae01d34a-d0c1-4134-9107-71814b4805af', null, true);

        $poiList = $client->getPoiList($poiListSearch);
        $this->assertInstanceOf('Rjsmelo\Fiware\Poi\Response\PoiList', $poiList);

        $query = $this->history->getLastRequest()->getQuery();
        $this->assertEquals('ae01d34a-d0c1-4134-9107-71814b4805af', $query['poi_id']);
        $this->assertEquals(true, $query['get_for_update']);
        $this->assertFalse($query->hasKey('component'));
    }
}
