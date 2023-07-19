<?php 

namespace Simformsolutions\FeatureToggleTestBundle\Feature;

/**
 * Feature class.
 * 
 */
class Feature implements FeatureInterface
{
    protected $name;
    protected $isEnabled;

    /**
     * @param string $name
     * @param string $isEnabled
     */
    public function __construct($name, $isEnabled)
    {
        $this->name = $name;
        $this->isEnabled = $isEnabled;
    }
    
    /**
     * Get name.
     * 
     * @return string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     * 
     * @param string
     */ 
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->isEnabled === true;
    }
}
