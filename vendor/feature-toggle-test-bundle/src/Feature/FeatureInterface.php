<?php

namespace Simformsolutions\FeatureToggleTestBundle\Feature;

/**
 * FeatureInterface interface
 */
interface FeatureInterface
{
    /**
     * @abstract 
     * @return boolean
     */
    function isEnabled();
}
