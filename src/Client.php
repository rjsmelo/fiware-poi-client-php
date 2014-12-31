<?php

namespace Rjsmelo\Fiware\Poi;

use Rjsmelo\Fiware\Poi\Server\PoiServer;
use Rjsmelo\Fiware\Poi\Query\RadialQuery;
use Rjsmelo\Fiware\Poi\Response\Components;
use Rjsmelo\Fiware\Poi\Response\Pois;

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
     * @param RadialQuery $query
     * @return Pois
     */
    public function radialSearch(RadialQuery $query)
    {
        $pois = $this->server->radialSearch($query);
        return new Pois($pois);
    }
} 