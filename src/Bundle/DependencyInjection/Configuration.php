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
                ->scalarNode('title')->end()
                ->scalarNode('description')->end()
                ->scalarNode('version')->end()
                ->scalarNode('cache_dir')->defaultValue('%kernel.project_dir%/var/prisma')->end()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('resource_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('operation_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('admin_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('frontend_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('tool_paths')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('operation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('collection')->defaultValue('none_action')->end()
                        ->scalarNode('item')->defaultValue('none_action')->end()
                        ->scalarNode('create')->defaultValue('none_action')->end()
                        ->scalarNode('update')->defaultValue('none_action')->end()
                        ->scalarNode('delete')->defaultValue('none_action')->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('collection')->defaultValue('none_action')->end()
                        ->scalarNode('item')->defaultValue('none_action')->end()
                        ->scalarNode('item_form')->defaultValue('none_action')->end()
                        ->scalarNode('create')->defaultValue('none_action')->end()
                        ->scalarNode('update')->defaultValue('none_action')->end()
                        ->scalarNode('delete')->defaultValue('none_action')->end()
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
