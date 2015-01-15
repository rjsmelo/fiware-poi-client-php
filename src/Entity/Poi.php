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

    public function has($component)
    {
        if (array_key_exists($component, $this->components)) {
            return true;
        }

        return false;
    }

    public function get($component)
    {
        if (!$this->has($component)) {
            return false;
        }

        return $this->components[$component];
    }

    public function delete($component)
    {
        if (!$this->has($component)) {
            return false;
        }

        unset($this->components[$component]);
    }
}
