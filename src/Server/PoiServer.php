<?php
namespace Rjsmelo\Fiware\Poi\Server;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Rjsmelo\Fiware\Poi\Entity\Poi;
use Rjsmelo\Fiware\Poi\Exception\BadRequest;
use Rjsmelo\Fiware\Poi\Exception\ServerError;
use Rjsmelo\Fiware\Poi\Query\BoundingBoxQuery;
use Rjsmelo\Fiware\Poi\Query\PoiListQuery;
use Rjsmelo\Fiware\Poi\Query\RadialQuery;

class PoiServer extends GuzzleHttpClient
{
    public function __construct($poiServerUrl, $options = null)
    {
        if (is_null($options)) {
            $options = array();
        }

        $options['base_url'] = $poiServerUrl;
        parent::__construct($options);
    }

    public function getComponents()
    {
        $response = $this->innerRequest('GET', 'get_components');

        return json_decode($response->getBody());
    }

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

        return json_decode($response->getBody());
    }

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

        return json_decode($response->getBody());
    }

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

        return json_decode($response->getBody());
    }

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

    public function addPoi(Poi $poi)
    {
        $response = $this->innerRequest(
            'POST',
            'add_poi',
            [
                'json' => $poi->asArray()
            ]
        );

        return json_decode($response->getBody());
    }

    public function updatePoi(Poi $poi)
    {
        $response = $this->innerRequest(
            'POST',
            'add_poi',
            [
                'json' => [$poi->getId() => $poi->asArray()]
            ]
        );

        return json_decode($response->getBody());
    }

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

    protected function innerRequest($operation, $uri, $options = [])
    {
        try {
            $request = $this->createRequest($operation, $uri, $options);
            $response = $this->send($request);

            return $response;
        } catch (ClientException $e) {
            throw new BadRequest($e->getResponse()->getBody()->__toString(), 400);
        } catch (ServerException $e) {
            throw new ServerError($e->getResponse()->getBody()->__toString(), 500);
        }
    }
}
