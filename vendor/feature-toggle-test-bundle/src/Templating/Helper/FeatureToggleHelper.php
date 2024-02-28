<?php

namespace Simformsolutions\FeatureToggleTestBundle\Templating\Helper;

/**
 * Helper that is used to inject html tags into code,
 * to wrap it with the correct css class
 */
class FeatureToggleHelper extends Helper
{
    protected $features;

    /**
     * @param array $featuresConfig An array containing 'name' and 'enabled' parameters
     */
    public function __construct($featuresConfig)
    {
        $features = array();
        foreach ($featuresConfig as $feature) {
            $features[$feature['name']] = $feature['enabled'];
        }

        $this->features = $features;
    }

    /**
     * If feature is set to hidden: wraps it with "feature-toggle" css class
     *
     * @param string $featureName
     * @return string
     */
    public function startToggle($featureName)
    {
        if ($this->isHidden($featureName)) {
            return '<div class="feature-toggle">';
        }
        return null;
    }

    /**
     * Closes the wrapping div, if features is hidden
     *
     * @param string $featureName
     * @return string
     */
    public function endToggle($featureName)
    {
        if ($this->isHidden($featureName)) {
            return '</div>';
        }
        return null;
    }

    /**
     * Checks feature config to see if it's disabled
     *
     * @param string $featureName
     * @return bool
     */
    protected function isHidden($featureName)
    {
        return isset($this->features[$featureName]) && !$this->features[$featureName];
    }

    /**
     * Return helper's name for symfony internals
     *
     * @return string
     */
    public function getName()
    {
        return 'feature_toggle';
    }

}
