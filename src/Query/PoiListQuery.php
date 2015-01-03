<?php
namespace Rjsmelo\Fiware\Poi\Query;

class PoiListQuery
{
    /**
     * poi_id=UUID - UUID of the POI. Several UUIDs can be given by separating them with commas.
     */
    private $poiIds = null;

    // Optional parameters:

    /**
     * component=component - POI data component name(s) to be included to results. Several component names can be given
     * by separating them with commas. If this parameter is not given, all components are included.
     */
    private $component = null;

    /**
     * get_for_update=true- The components requested are returned with all language and other variants and possible
     * metadata for inspection and edit.
     */
    private $forUpdate = null;

    /**
     * Query Parameters Available for a Poi Search
     *
     * The parameter $poiIds is mandatory, the rest are optional (default value is null)
     *
     * @param (string|Array) $poiIds    UUID of the POI
     * @param null           $component POI data component name(s) to be included to results
     * @param null           $forUpdate Request POI for update
     */
    public function __construct(
        $poiIds,
        $component = null,
        $forUpdate = null
    ) {
        if (!is_array($poiIds)) {
            $poiIds = array($poiIds);
        }
        $this->poiIds = $poiIds;
        $this->component = $component;
        $this->forUpdate = $forUpdate;
    }

    public function asArray()
    {
        return [
            'poiIds' => $this->poiIds,
            'component' => $this->component,
            'forUpdate' => $this->forUpdate
        ];
    }
}
