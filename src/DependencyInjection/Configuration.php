<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('setono_sylius_pagination');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('setono_sylius_pagination');
        }

        $rootNode
            ->addDefaultsIfNotSet()
            ->fixXmlConfig('event')
            ->children()
                ->scalarNode('page_parameter')
                    ->defaultValue('page')
                    ->cannotBeEmpty()
                    ->info('The query parameter indicating af pagination')
                    ->example('page')
                ->end()
                ->booleanNode('listen_to_resources')->defaultTrue()->end()
                ->arrayNode('events')
                    ->scalarPrototype()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
