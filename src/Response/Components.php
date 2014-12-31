<?php

namespace Rjsmelo\Fiware\Poi\Response;

class Components
{
    private $components = array();

    public function __construct($components = null)
    {
        if (is_object($components) && is_array($components->components)) {
            $this->components = array_combine($components->components, $components->components);
        }
    }

    public function has($componentName)
    {
        if (array_key_exists($componentName, $this->components)) {
            return true;
        }
        return false;
    }
} 