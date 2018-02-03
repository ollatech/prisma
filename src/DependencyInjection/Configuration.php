<?php
namespace Olla\Prisma\DependencyInjection;

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
                ->scalarNode('title')->defaultValue('Prisma Framework')->end()
                ->scalarNode('description')->defaultValue('')->end()
                ->scalarNode('version')->defaultValue('0.0.0')->end()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('entity_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('operation_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('restapi_operation_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('graphql_type_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('graphql_query_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('graphql_mutation_paths')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('graphql_subscription_paths')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('broker')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('graphql')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultTrue()
                                ->end()
                                ->arrayNode('schema_paths')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('operation_paths')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->scalarNode('cache_dir')
                                    ->defaultValue('')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('restapi')
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('security')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('strategy')
                            ->defaultValue('strict')
                        ->end()
                        ->arrayNode('scopes')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('oauth')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultFalse()
                                ->end()
                                ->scalarNode('clientId')
                                    ->defaultValue('')
                                ->end()
                                ->scalarNode('clientSecret')
                                    ->defaultValue('')
                                ->end()
                                ->scalarNode('type')
                                    ->defaultValue('oauth2')
                                ->end()
                                ->scalarNode('prisma')
                                    ->defaultValue('application')
                                ->end()
                                ->scalarNode('tokenUrl')
                                    ->defaultValue('/oauth/v2/token')
                                ->end()
                                ->scalarNode('authorizationUrl')
                                    ->defaultValue('/oauth/v2/auth')
                                ->end()
                                ->arrayNode('scopes')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('storage')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('multi')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('layer')
                            ->children()
                                ->scalarNode('primary')
                                    ->defaultValue('orm')
                                ->end()
                                ->scalarNode('cache')
                                    ->defaultValue('redis')
                                ->end()
                                ->scalarNode('search')
                                    ->defaultValue('algolia')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('storages')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('credentials')
                            ->children()
                                ->arrayNode('algolia')
                                    ->children()
                                        ->scalarNode('app_id')->end()
                                        ->scalarNode('app_key')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('data')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('translation')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('locale')
                                    ->defaultValue('en')
                                ->end()
                                ->arrayNode('locales')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('collection')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('order')
                                    ->defaultValue('ASC')
                                ->end() 
                                ->arrayNode('pagination')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->integerNode('items_per_page')
                                            ->defaultValue(30)
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                        ->end()
                        ->arrayNode('controller_paths')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
