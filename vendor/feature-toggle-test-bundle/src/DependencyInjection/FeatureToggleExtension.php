<?php

namespace Simformsolutions\FeatureToggleTestBundle\DependencyInjection;

use Simformsolutions\FeatureToggleTestBundle\Feature\Feature;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Semantic feature toggling configuration.
 */
class FeatureToggleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['feature'] as $feature) {
            $feature = new Feature($feature['name'], $feature['enabled']);
            $featureDefinition = new Definition(
                $container->getParameter('feature_toggle.feature.class'),
                array(
                    'name' => $feature->getName(),
                    'enabled' => $feature->isEnabled()
                )
            );
            $featureDefinition->addTag('feature_toggle.features');

            $container->setDefinition('feature_toggle.features.'.$feature->getName(), $featureDefinition);
        }

        $manager = $container->getDefinition('feature_toggle.manager');
        foreach ($container->findTaggedServiceIds('feature_toggle.feature') as $id => $attributes) {
            $manager->addMethodCall('add', array(new Reference($id)));
        }

        $definition = new Definition('Simformsolutions\FeatureToggleTestBundle\Twig\FeatureToggleExtension', array($manager));
        $definition->addTag('twig.extension');
        $container->setDefinition('feature_toggle.twig.extension', $definition);
    }
}
