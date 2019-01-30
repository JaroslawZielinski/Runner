<?php

/**
 * Application's Configuration
 *
 * @author Jaroslaw Zielinski
 */
namespace JaroslawZielinski\Runner\Bootstrap;

use ArrayAccess;


/**
 * Class Configuration
 * @package JaroslawZielinski\Runner\Bootstrap
 */
class Configuration implements ArrayAccess {

    /**
     * @var
     */
    protected $container;

    /**
     * Configuration constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function offsetExists ($offset) {

        return isset($this->container[$offset]);

    }

    public function offsetGet ($offset) {

        return isset($this->container[$offset]) ? $this->container[$offset] : null;

    }

    public function offsetSet ($offset, $value) {

        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }

    }

    public function offsetUnset ($offset) {

        unset($this->container[$offset]);

    }

}
