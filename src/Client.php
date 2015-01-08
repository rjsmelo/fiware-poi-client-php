<?php
namespace Rjsmelo\Fiware\Poi;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Rjsmelo\Fiware\Poi\Entity\Poi;
use Rjsmelo\Fiware\Poi\Query\RadialQuery;
use Rjsmelo\Fiware\Poi\Query\BoundingBoxQuery;
use Rjsmelo\Fiware\Poi\Query\PoiListQuery;
use Rjsmelo\Fiware\Poi\Response\Components;
use Rjsmelo\Fiware\Poi\Response\PoiList;
use Rjsmelo\Fiware\Poi\Exception\BadRequest;
use Rjsmelo\Fiware\Poi\Exception\ServerError;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $server;

    /**
     * @param (string|\GuzzleHttp\Client) $server
     */
    public function __construct($server)
    {
        if ($server instanceof GuzzleHttpClient) {
            $this->server = $server;

            return;
        }

        $this->server = new GuzzleHttpClient(['base_url' => $server]);
    }

    /**
     * Return the list of POI data components available from the server
     * @return Components
     */
    public function getComponents()
    {
        $response = $this->innerRequest('GET', 'get_components');
        $components = json_decode($response->getBody());

        return new Components($components);
    }

    /**
     * Return the data of POIs within a given distance from a given location
     * @param  RadialQuery $query
     * @return PoiList
     */
    public function radialSearch(RadialQuery $query)
    {
        $mapping = [
            'latitude' => 'lat',
            'longitude' => 'lon',
            'radius' => 'radius',
            'category' => 'category',
            'component' => 'component',
            'maxResults' => 'max_results',
            'beginTime' => 'begin_time',
            'endTime' => 'end_time',
            'minMinutes' => 'min_minutes',
        ];

        $params = $this->mapQueryParameters($query->asArray(), $mapping);

        $response = $this->innerRequest(
            'GET',
            'radial_search',
            [
                'query' => $params
            ]
        );

        $pois = json_decode($response->getBody());

        return new PoiList($pois);
    }

    /**
     * Return the data of POIs within a given bounding box
     * @param  BoundingBoxQuery $query
     * @return PoiList
     */
    public function boundingBoxSearch(BoundingBoxQuery $query)
    {
        $mapping = [
            'north' => 'north',
            'south' => 'south',
            'east' => 'east',
            'west' => 'west',
            'category' => 'category',
            'component' => 'component',
            'maxResults' => 'max_results',
            'beginTime' => 'begin_time',
            'endTime' => 'end_time',
            'minMinutes' => 'min_minutes',
        ];

        $params = $this->mapQueryParameters($query->asArray(), $mapping);

        $response = $this->innerRequest(
            'GET',
            'bbox_search',
            [
                'query' => $params
            ]
        );

        $pois = json_decode($response->getBody());

        return new PoiList($pois);
    }

    /**
     * Return the data of POIs listed in the query
     * @param  PoiListQuery $query
     * @return PoiList
     */
    public function getPoiList(PoiListQuery $query)
    {
        $mapping = [
            'poiIds' => 'poi_id',
            'component' => 'component',
            'forUpdate' => 'get_for_update',
        ];

        $params = $this->mapQueryParameters($query->asArray(), $mapping);

        $params['poi_id'] = implode(',', $params['poi_id']);

        $response = $this->innerRequest(
            'GET',
            'get_pois',
            [
                'query' => $params
            ]
        );

        $pois = json_decode($response->getBody());

        return new PoiList($pois);
    }

    /**
     * Delete existing POI
     * @param string $poiId
     */
    public function deletePoi($poiId)
    {
        $response = $this->innerRequest(
            'DELETE',
            'delete_poi',
            [
                'query' => ['poi_id' => $poiId]
            ]
        );
    }

    /**
     * Add a new POI
     * @param  Poi   $poi
     * @return mixed
     */
    public function addPoi(Poi $poi)
    {
        $response = $this->innerRequest(
            'POST',
            'add_poi',
            [
                'json' => $poi->asArray()
            ]
        );

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * Update a Poi
     * @param Poi $poi
     */
    public function updatePoi(Poi $poi)
    {
        $response = $this->innerRequest(
            'POST',
            'add_poi',
            [
                'json' => [$poi->getId() => $poi->asArray()]
            ]
        );
    }

    /**
     * Helper function to map the query objects to the server request
     *
     * @param  array $query
     * @param  array $mapDefinition
     * @return array
     */
    protected function mapQueryParameters(Array $query, Array $mapDefinition)
    {
        $params = array();
        foreach ($query as $key => $value) {
            if (!is_null($value) && array_key_exists($key, $mapDefinition)) {
                $params[$mapDefinition[$key]] = $value;
            }
        }

        return $params;
    }

    /**
     * @param  string                                $operation
     * @param  string                                $url
     * @param  array                                 $options
     * @return \GuzzleHttp\Message\ResponseInterface
     * @throws Exception\BadRequest
     * @throws Exception\ServerError
     */
    protected function innerRequest($operation, $url, $options = [])
    {
        try {
            $request = $this->server->createRequest($operation, $url, $options);
            $response = $this->server->send($request);
        } catch (ClientException $e) {
            throw new BadRequest($e->getResponse()->getBody()->__toString(), 400);
        } catch (ServerException $e) {
            throw new ServerError($e->getResponse()->getBody()->__toString(), 500);
        }

        return $response;
    }
}
