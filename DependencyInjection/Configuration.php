<?php

namespace So\LogboardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('logboard');
        $rootNode->prototype('array')
            ->children()
            ->scalarNode('title')->defaultValue('intitled')->end()
            ->scalarNode('src')->example('file')->end()
            ->scalarNode('data')->example('%kernel.root_dir%/logs/dev.log')->defaultNull()->end()
            ->scalarNode('exclude')->defaultNull()->end()
            ->scalarNode('engine')->defaultValue('file_storage')->end()
            ->scalarNode('decompiler')->defaultValue('pattern_matcher')->end()
                ->arrayNode("menu")
                    ->prototype('array')
                          ->children()
                                ->scalarNode("split")->example('/[a-zA-Z]*/')->defaultValue('error')->end()
                                ->scalarNode('title')->defaultValue('intitled sub menu')->end()
                                ->scalarNode('src')->end()
                                ->scalarNode('data')->end()
                                ->scalarNode('exclude')->end()
                                ->scalarNode('engine')->end()
                                ->scalarNode('decompiler')->end()
                          ->end()
                    ->end()
                ->end()
            ->end()
         ->end();

        return $treeBuilder;
    }
}
