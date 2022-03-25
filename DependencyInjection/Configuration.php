<?php

namespace Fervo\PubnubBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('fervo_pubnub');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('publish_key')->isRequired()->end()
                ->scalarNode('subscribe_key')->isRequired()->end()
                ->scalarNode('secret_key')->defaultFalse()->end()
                ->arrayNode('uuid')
                    ->children()
                        ->scalarNode('property_path')->defaultFalse()->end()
                        ->scalarNode('service')->defaultFalse()->end()
                        ->booleanNode('unique_for_anonymous')->defaultTrue()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
