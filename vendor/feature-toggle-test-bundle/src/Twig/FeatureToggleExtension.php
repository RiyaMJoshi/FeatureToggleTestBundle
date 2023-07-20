<?php

namespace Simformsolutions\FeatureToggleTestBundle\Twig;

use Simformsolutions\FeatureToggleTestBundle\Feature\FeatureManager;
use Twig\Extension\AbstractExtension;

/**
 * This is the main extension file enabling feature toggling
 */
class FeatureToggleExtension extends AbstractExtension
{
    protected $manager;

    public function __construct(FeatureManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return FeatureManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    public function getTokenParsers()
    {
        return array(new FeatureToggleTokenParser($this->manager));
    }

    public function getFilters()
    {
        return array();
    }
    public function getName()
    {
        return 'featuretoggle';
    }
}
