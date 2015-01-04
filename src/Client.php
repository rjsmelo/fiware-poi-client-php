<?php
namespace Rjsmelo\Fiware\Poi;

use Rjsmelo\Fiware\Poi\Server\PoiServer;
use Rjsmelo\Fiware\Poi\Query\RadialQuery;
use Rjsmelo\Fiware\Poi\Query\BoundingBoxQuery;
use Rjsmelo\Fiware\Poi\Query\PoiListQuery;
use Rjsmelo\Fiware\Poi\Response\Components;
use Rjsmelo\Fiware\Poi\Response\PoiList;

class Client
{
    protected $server;

    public function __construct(PoiServer $server)
    {
        $this->server = $server;
    }

    /**
     * Return the list of POI data components available from the server
     * @return Components
     */
    public function getComponents()
    {
        $components = $this->server->getComponents();

        return new Components($components);
    }

    /**
     * Return the data of POIs within a given distance from a given location
     * @param  RadialQuery $query
     * @return PoiList
     */
    public function radialSearch(RadialQuery $query)
    {
        $pois = $this->server->radialSearch($query);

        return new PoiList($pois);
    }

    /**
     * Return the data of POIs within a given bounding box
     * @param  BoundingBoxQuery $query
     * @return PoiList
     */
    public function boundingBoxSearch(BoundingBoxQuery $query)
    {
        $pois = $this->server->boundingBoxSearch($query);

        return new PoiList($pois);
    }

    /**
     * Return the data of POIs listed in the query
     * @param  PoiListQuery $query
     * @return PoiList
     */
    public function getPoiList(PoiListQuery $query)
    {
        $pois = $this->server->getPoiList($query);

        return new PoiList($pois);
    }

    /**
     * Delete existing POI
     * @param string $poiId
     */
    public function deletePoi($poiId)
    {
        $this->server->deletePoi($poiId);
    }
}
