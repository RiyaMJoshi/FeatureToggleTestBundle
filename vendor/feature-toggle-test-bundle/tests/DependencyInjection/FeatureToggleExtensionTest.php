<?php

namespace Simformsolutions\FeatureToggleTestBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Simformsolutions\FeatureToggleTestBundle\DependencyInjection\FeatureToggleExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig\Environment;

class FeatureToggleExtensionTest extends KernelTestCase // TestCase 
{
    private $kernel;
    private $container;

    public static function assertSaneContainer(Container $container, $message = '')
    {
        $errors = array();
        foreach ($container->getServiceIds() as $id) {
            try {
                $container->get($id);
            } catch (\Exception $e) {
                $errors[$id] = $e->getMessage();
            }
        }

        self::assertEquals(array(), $errors, $message);
    }

    protected function setUp(): void
    {
        // $this->kernel = $this->getMock('Symfony\\Component\\HttpKernel\\KernelInterface');

        $this->container = new ContainerBuilder();
        // $this->container->addScope(new Scope('request'));
        $this->container->register('request', Request::class)->setShared(false);
        $this->container->register('templating.helper.assets', $this->getMockClass('Symfony\\Component\\Templating\\Helper\\AssetsHelper'));
        $this->container->register('templating.helper.router', $this->getMockClass('Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper'))
            ->addArgument(new Definition($this->getMockClass('Symfony\\Component\\Routing\\RouterInterface')));
        $this->container->register('twig', Environment::class);
        $this->container->setParameter('kernel.bundles', []);
        $this->container->setParameter('kernel.cache_dir', __DIR__);
        $this->container->setParameter('kernel.debug', false);
        $this->container->setParameter('kernel.root_dir', __DIR__);
        $this->container->setParameter('kernel.charset', 'UTF-8');
        // $this->container->set('kernel', $this->kernel);
    }

    public function testDefaultConfig()
    {
        $extension = new FeatureToggleExtension();
        $extension->load(array(array()), $this->container);

        $this->assertFalse($this->container->has('feature_toggle.features'));
    }

    public function testConfig()
    {
        $extension = new FeatureToggleExtension();
        $extension->load(array(array(
            'features' => array(
                'test_enabled' => array(
                    'name' => 'test_enabled',
                    'enabled' => true,
                ),
                'test_disabled' => array(
                    'name' => 'test_disabled',
                    'enabled' => false,
                )
            )
        )), $this->container);

        $this->assertTrue($this->container->has('feature_toggle.features.test_enabled'));
        $this->assertTrue($this->container->has('feature_toggle.features.test_disabled'));
    }
}
