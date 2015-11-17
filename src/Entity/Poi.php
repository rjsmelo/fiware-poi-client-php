<?php
namespace Rjsmelo\Fiware\Poi\Entity;

class Poi
{
    private $id;
    private $components;

    /**
     * Poi constructor, accepts the POI Id and the list of components
     *
     * @param string $id
     * @param array|stdClass $components
     */
    public function __construct($id = null, $components = null)
    {
        $this->id = $id;

        if (is_object($components)){ //make sure we store components as an array
            $components = json_decode(json_encode($components), true);
        }
        $this->components = $components;
    }

    /**
     * Returns POI id
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns an Array with all components, or a empty array if no components are set
     *
     * @return array
     */
    public function asArray()
    {
        if (!is_array($this->components)) {
            return [];
        }

        return $this->components;
    }

    /**
     * Returns a list with the name of the components of the POI
     *
     * @return array
     */
    public function components()
    {
        $components = [];
        foreach ($this->components as $key => $value) {
            $components[] = $key;
        }

        return $components;
    }

    /**
     * Check if a specific component is available
     *
     * @param $component
     * @return bool
     */
    public function has($component)
    {
        if (array_key_exists($component, $this->components)) {
            return true;
        }

        return false;
    }

    /**
     * Get the values for a specific component
     *
     * @param $component
     * @return bool
     */
    public function get($component)
    {
        if (!$this->has($component)) {
            return false;
        }

        return $this->components[$component];
    }

    /**
     * Delete a specific component
     *
     * @param $component
     * @return bool
     */
    public function delete($component)
    {
        if (!$this->has($component)) {
            return false;
        }

        unset($this->components[$component]);
    }
}
