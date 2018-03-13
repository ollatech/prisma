<?php
namespace Olla\Prisma\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;


final class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('olla_prisma');
        $rootNode
            ->children()
                ->scalarNode('cache_dir')->defaultValue('%kernel.project_dir%/var/prisma')->end()
                ->arrayNode('operations')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('api')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('search')->end()
                                ->scalarNode('collection')->end()
                                ->scalarNode('item')->end()
                                ->scalarNode('create')->end()
                                ->scalarNode('update')->end()
                                ->scalarNode('delete')->end()
                            ->end()
                        ->end()
                        ->arrayNode('admin')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('collection')->end()
                                ->scalarNode('item')->end()
                                ->scalarNode('item_form')->end()
                                ->scalarNode('create')->end()
                                ->scalarNode('update')->end()
                                ->scalarNode('delete')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('dirs')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('api_app')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('admin_app')
                            ->prototype('scalar')->end()
                        ->end()    
                        ->arrayNode('frontend_app')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('account_app')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('console_app')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('tool_app')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('resource_app')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('api_module')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('admin_module')
                            ->prototype('scalar')->end()
                        ->end()    
                        ->arrayNode('frontend_module')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('account_module')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('console_module')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('tool_module')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('resource_module')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
