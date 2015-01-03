<?php
namespace Rjsmelo\Fiware\Poi\Query;

class RadialQuery
{
    /**
     * lat=latitude - Latitude of the center of the search circle [degrees]
     */
    private $latitude = null;

    /**
     * lon=longitude - Longitude of the center of the search circle [degrees]
     */
    private $longitude = null;

    // Optional parameters:

    /**
     * radius=radius - Radius of the search circle [meters], default is implementation dependent
     */
    private $radius = null;

    /**
     * category=category - POI category/categories to be included to results. Several categories can be given by
     * separating them with commas. If this parameter is not given, all categories are included.
     */
    private $category = null;

    /**
     * component=component - POI data component name(s) to be included to results. Several component names can be given
     * by separating them with commas. If this parameter is not given, all components are included.
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
     * min_minutes=min_minutes - Minimum time of availability in minutes. Optional.
     * If begin_time is defined, default: a short time > 0.
     */
    private $minMinutes = null;

    /**
     * Query Parameters Available for a Radial Search
     *
     * The parameters $latitude and $longitude are mandatory, the rest are optional (default value is null)
     *
     * Time Formats: ISO 8601 adaptation format [1] is used for times. However, it is allowed to leave the time zone
     * definition out. If time zone is missing, the local time zone of the POI is used
     *
     * [1] http://www.w3.org/TR/NOTE-datetime
     *
     * @param float $latitude   Latitude of the center of the search circle [degrees]
     * @param float $longitude  Longitude of the center of the search circle [degrees]
     * @param null  $radius     Radius of the search circle [meters], default is implementation dependent
     * @param null  $category   POI category/categories to be included to results
     * @param null  $component  POI data component name(s) to be included to results
     * @param null  $maxResults Maximum number of POIs returned
     * @param null  $beginTime  When time of interest begins
     * @param null  $endTime    When time of interest ends
     * @param null  $minMinutes Minimum time of availability in minutes
     */
    public function __construct(
        $latitude,
        $longitude,
        $radius = null,
        $category = null,
        $component = null,
        $maxResults = null,
        $beginTime = null,
        $endTime = null,
        $minMinutes = null
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->radius = $radius;
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
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'radius' => $this->radius,
            'category' => $this->category,
            'component' => $this->component,
            'maxResults' => $this->maxResults,
            'beginTime' => $this->beginTime,
            'endTime' => $this->endTime,
            'minMinutes' => $this->minMinutes,
        ];
    }
}
