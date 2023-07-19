<?php

namespace Simformsolutions\FeatureToggleTestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('feature_toggle'); // new TreeBuilder('feature_toggle_test');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('features')
                    ->canBeUnset()
                    ->treatNullLike(array())
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->defaultValue('')->end()
                            ->booleanNode('enabled')->defaultValue(true)->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
