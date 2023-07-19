<?php

namespace Simformsolutions\FeatureToggleTestBundle\Feature;

/**
 * FeatureManager class.
 */
class FeatureManager implements \ArrayAccess
{
    protected $features;

    public function __construct(array $features = array())
    {
        $this->features = $features;
    }

    /**
     * @param $feature
     */
    public function add($feature)
    {
        $this->offsetSet($feature->getName(), $feature);
    }

    /**
     * @param $featureName
     * @return boolean
     */
    public function has($featureName)
    {
        return $this->offsetExists($featureName);
    }

    /**
     * @param $featureName
     * @return Feature
     */
    public function get($featureName)
    {
        return $this->offsetGet($featureName);
    }

    /**
     * Whether a offset exists
     * 
     * @param mixed $offset
     * @return bool Returns true on success or false on failure.
     */
    public function offsetExists($offset): bool
    {
        return isset($this->features[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->offsetExists($offset) ? $this->features[$offset] : null;
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->features[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->features[$offset]);
    }
}
