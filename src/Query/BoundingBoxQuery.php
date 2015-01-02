<?php

namespace Rjsmelo\Fiware\Poi\Query;

class BoundingBoxQuery
{
    /**
     * north=latitude - Latitude of the northern edge of the bounding box [degrees]
     */
    private $north = null;

    /**
     * south=latitude - Latitude of the southern edge of the bounding box [degrees]
     */
    private $south = null;

    /**
     * east=longitude - Longitude of the eastern edge of the bounding box [degrees]
     */
    private $east = null;

    /**
     * west=longitude - Longitude of the western edge of the bounding box [degrees]
     *
     */
    private $west = null;

    // Optional parameters:

    /**
     * category=category - POI category/categories to be included to results. Several categories can be given by separating them with commas. If this parameter is not given, all categories are included.
     */
    private $category = null;

    /**
     * component=component - POI data component name(s) to be included to results. Several component names can be given by separating them with commas. If this parameter is not given, all components are included.
     */
    private $component = null;

    /**
     * max_results=max_results - Maximum number of POIs returned.
     */
    private $maxResults = null;

    /**
     * begin_time=begin_time - When time of interest begins. See 'Time format' below. Optional, requires end_time.
     */
    private $beginTime = null;

    /**
     * end_time=end_time - When time of interest ends. See 'Time format' below. Required, if begin_time is defined.
     */
    private $endTime = null;

    /**
     * min_minutes=min_minutes - Minimum time of availability in minutes. Optional. If begin_time is defined, default: a short time > 0.
     */
    private $minMinutes = null;

    /**
     * Query Parameters Available for a Bounding Box Search
     *
     * The parameters $north, $south, $east and $west are mandatory, the rest are optional (default value is null)
     *
     * Time Formats: ISO 8601 adaptation format [1] is used for times. However, it is allowed to leave the time zone
     * definition out. If time zone is missing, the local time zone of the POI is used
     *
     * [1] http://www.w3.org/TR/NOTE-datetime
     *
     * @param float $north Latitude of the northern edge of the bounding box [degrees]
     * @param float $south Latitude of the southern edge of the bounding box [degrees]
     * @param float $east Longitude of the eastern edge of the bounding box [degrees]
     * @param float $west Longitude of the western edge of the bounding box [degrees]
     * @param null $category POI category/categories to be included to results
     * @param null $component POI data component name(s) to be included to results
     * @param null $maxResults Maximum number of POIs returned
     * @param null $beginTime When time of interest begins
     * @param null $endTime When time of interest ends
     * @param null $minMinutes Minimum time of availability in minutes
     */
    public function __construct(
        $north,
        $south,
        $east,
        $west,
        $category = null,
        $component = null,
        $maxResults = null,
        $beginTime = null,
        $endTime = null,
        $minMinutes = null
    ) {
        $this->north = $north;
        $this->south = $south;
        $this->east = $east;
        $this->west = $west;
        $this->category = $category;
        $this->component = $component;
        $this->maxResults = $maxResults;
        $this->beginTime = $beginTime;
        $this->endTime = $endTime;
        $this->minMinutes = $minMinutes;
    }

    public function asArray()
    {
        return [
            'north' => $this->north,
            'south' => $this->south,
            'east' => $this->east,
            'west' => $this->west,
            'category' => $this->category,
            'component' => $this->component,
            'maxResults' => $this->maxResults,
            'beginTime' => $this->beginTime,
            'endTime' => $this->endTime,
            'minMinutes' => $this->minMinutes,
        ];
    }
} 