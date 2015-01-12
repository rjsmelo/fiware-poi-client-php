<?php
namespace Rjsmelo\Fiware\Poi\Entity;

class Poi
{
    private $id;
    private $components;

    public function __construct($id = null, $components = null)
    {
        $this->id = $id;
        $this->components = $components;
    }

    public function getId()
    {
        return $this->id;
    }

    public function asArray()
    {
        if (!is_array($this->components)) {
            return [];
        }

        return $this->components;
    }

    public function components()
    {
        $components = [];
        foreach ($this->components as $key => $value) {
            $components[] = $key;
        }

        return $components;
    }
}
