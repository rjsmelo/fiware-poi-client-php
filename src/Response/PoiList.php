<?php

namespace Rjsmelo\Fiware\Poi\Response;

class PoiList
{
    protected $poiList = null;

    public function __construct($poiList = null)
    {
        if (is_object($poiList) && is_object($poiList->pois)) {
            $this->poiList = $poiList->pois;
        }
    }

    public function asArray()
    {
        return json_decode(json_encode($this->poiList), true);
    }
} 