<?php
namespace Rjsmelo\Fiware\Poi\Response;

use Rjsmelo\Fiware\Poi\Entity\Poi;

class PoiList
{
    protected $poiList = [];

    public function __construct($poiList = null)
    {
        if (is_object($poiList) && is_object($poiList->pois)) {
            foreach ($poiList->pois as $id => $poi) {
                $this->poiList[$id] = new Poi($id, $poi);
            }
        }
    }

    public function asArray()
    {
        $poiList = array();
        foreach ($this->poiList as $poi) {
            $poiList[$poi->getId()] = $poi->asArray();
        }

        return $poiList;
    }
}
