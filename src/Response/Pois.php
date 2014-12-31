<?php

namespace Rjsmelo\Fiware\Poi\Response;

class Pois
{
    protected $pois = null;

    public function __construct($pois = null)
    {
        if (is_object($pois) && is_object($pois->pois)) {
            $this->pois = $pois->pois;
        }
    }

    public function asArray()
    {
        return json_decode(json_encode($this->pois), true);
    }
} 