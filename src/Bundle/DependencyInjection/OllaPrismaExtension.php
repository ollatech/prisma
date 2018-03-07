<?php

namespace Olla\Prisma\Bundle\DependencyInjection;


use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;
   

final class OllaPrismaExtension extends Extension implements PrependExtensionInterface
{

    public function prepend(ContainerBuilder $container)
    {
        if (!$frameworkConfiguration = $container->getExtensionConfig('framework')) {
            return;
        }
        foreach ($frameworkConfiguration as $frameworkParameters) {
            if (isset($frameworkParameters['property_info'])) {
                $propertyInfoConfig = $propertyInfoConfig ?? $frameworkParameters['property_info'];
            }
        }
        if (!isset($propertyInfoConfig['enabled'])) {
            $container->prependExtensionConfig('framework', ['property_info' => ['enabled' => true]]);
        }
    }
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->reconfig($configs, $container);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('metadata.xml');
    }
    private function reconfig(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('prisma_cache_dir', $config['cache_dir']);
        $container->setParameter('prisma_resource_paths', $config['mapping']['resource_paths']);
        $container->setParameter('prisma_operation_paths', $config['mapping']['operation_paths']);
        $container->setParameter('prisma_admin_paths', $config['mapping']['admin_paths']);
        $container->setParameter('prisma_frontend_paths', $config['mapping']['frontend_paths']);

        $container->setParameter('prisma_collection_operation', $config['operation']['collection']);
        $container->setParameter('prisma_item_operation', $config['operation']['item']);
        $container->setParameter('prisma_create_operation', $config['operation']['create']);
        $container->setParameter('prisma_update_operation', $config['operation']['update']);
        $container->setParameter('prisma_delete_operation', $config['operation']['delete']);

        $container->setParameter('prisma_collection_admin', $config['admin']['collection']);
        $container->setParameter('prisma_item_admin', $config['admin']['item']);
        $container->setParameter('prisma_item_form_admin', $config['admin']['item_form']);
        $container->setParameter('prisma_create_admin', $config['admin']['create']);
        $container->setParameter('prisma_update_admin', $config['admin']['update']);
        $container->setParameter('prisma_delete_admin', $config['admin']['delete']);

        $container->setParameter('prisma_api_entrypoint', $config['entrypoint']['api']);
        $container->setParameter('prisma_admin_entrypoint', $config['entrypoint']['admin']);
        $container->setParameter('prisma_frontend_entrypoint', $config['entrypoint']['frontend']);
        $container->setParameter('prisma_graphql_entrypoint', $config['entrypoint']['graphql']);

        //dirs
        $vendorDir = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);
        $api_default_dirs = [
            'olla' => $baseDir.'/Operations/Api'
        ];;
        $api_module_dirs = [];
        $admin_default_dirs = [
            'olla' => $baseDir.'/Operations/Admin'
        ];;
        $admin_module_dirs = [];
        $frontend_default_dirs = [
            'olla' => $baseDir.'/Operations/Frontend'
        ];
        $frontend_module_dirs = [];
        $resource_default_dirs = [];
        $resource_module_dirs = [];
     
        if(isset($config['dirs'])) {
            $dirs = $config['dirs'];
            if(isset($dirs['api_default'])) {
                $api_default_dirs = $dirs['api_default'];
            }
            if(isset($dirs['api_module'])) {
                $api_module_dirs = $dirs['api_module'];
            }
            if(isset($dirs['admin_default'])) {
                $admin_default_dirs = $dirs['admin_default'];
            }
            if(isset($dirs['admin_module'])) {
                $admin_module_dirs = $dirs['admin_module'];
            }
            if(isset($dirs['frontend_default'])) {
                $frontend_default_dirs = $dirs['frontend_default'];
            }
            if(isset($dirs['frontend_module'])) {
                $frontend_module_dirs = $dirs['frontend_module'];
            }
            if(isset($dirs['resource_default'])) {
                $api_default_dirs = $dirs['resource_default'];
            }
            if(isset($dirs['resource_module'])) {
                $resource_module_dirs = $dirs['resource_module'];
            }
        }
        $container->setParameter('olla.api_default_dirs', $api_default_dirs);
        $container->setParameter('olla.api_module_dirs', $api_module_dirs);
        $container->setParameter('olla.admin_default_dirs', $admin_default_dirs);
        $container->setParameter('olla.admin_module_dirs', $admin_module_dirs);
        $container->setParameter('olla.frontend_default_dirs', $frontend_default_dirs);
        $container->setParameter('olla.frontend_module_dirs', $frontend_module_dirs);
        $container->setParameter('olla.resource_default_dirs', $resource_default_dirs);
        $container->setParameter('olla.resource_module_dirs', $resource_module_dirs);
    }
}
