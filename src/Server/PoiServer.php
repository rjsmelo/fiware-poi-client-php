<?php

namespace Rjsmelo\Fiware\Poi\Server;

use GuzzleHttp\Client as GuzzleHttpClient;
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
        $response = $this->get('get_components');
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

        $params = array();
        foreach ($query->asArray() as $key => $value) {
            if (!is_null($value)) {
                $params[$mapping[$key]] = $value;
            }
        }

        $response = $this->get(
            'radial_search',
            [
                'query' => $params
            ]
        );

        return json_decode($response->getBody());
    }

    public function boundingBoxSearch($query)
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

        $params = array();
        foreach ($query->asArray() as $key => $value) {
            if (!is_null($value)) {
                $params[$mapping[$key]] = $value;
            }
        }

        $response = $this->get(
            'bbox_search',
            [
                'query' => $params
            ]
        );

        return json_decode($response->getBody());
    }
}