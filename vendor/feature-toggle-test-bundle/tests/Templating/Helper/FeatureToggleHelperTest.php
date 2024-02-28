<?php

namespace Simformsolutions\FeatureToggleTestBundle\Tests\Templating\Helper;

use PHPUnit\Framework\TestCase;
use Simformsolutions\FeatureToggleTestBundle\Templating\Helper\FeatureToggleHelper;

class FeatureToggleHelperTest extends TestCase
{
    public function testDisabledFeature()
    {
        $helper = new FeatureToggleHelper(array(
            array(
                'name' => 'test',
                'enabled' => false,
            )
        ));

        $this->assertEquals(
            '<div class="feature-toggle">',
            $helper->startToggle('test')
        );

        $this->assertEquals(
            '</div>',
            $helper->endToggle('test')
        );
    }
}
