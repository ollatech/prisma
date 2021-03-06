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
  
        $container->setParameter('olla.operations', $config['operations']);

        //dirs
        $vendorDir = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);
        $projectDir = $container->getParameter('kernel.project_dir');
        $api_default_dirs = [
            'olla' => $baseDir.'/Operations/Api'
        ];
        $api_module_dirs = [];
        $api_app_dirs = [
            'olla' => $projectDir.'/src/Operations/Api'
        ];
        $admin_default_dirs = [
            'olla' => $baseDir.'/Operations/Admin'
        ];
        $admin_module_dirs = [];
        $admin_app_dirs = [
            'olla' => $projectDir.'/src/Operations/Admin'
        ];
        $frontend_default_dirs = [
            'olla' => $baseDir.'/Operations/Frontend'
        ];
        $frontend_module_dirs = [];
        $frontend_app_dirs = [
            'olla' => $projectDir.'/src/Operations/Frontend'
        ];

        $account_default_dirs = [
            'olla' => $baseDir.'/Operations/Account'
        ];
        $account_module_dirs = [];
        $account_app_dirs = [
            'olla' => $projectDir.'/src/Operations/Account'
        ];

        $console_default_dirs = [
            'olla' => $baseDir.'/Operations/Console'
        ];
        $console_module_dirs = [];
        $console_app_dirs = [
            'olla' => $projectDir.'/src/Operations/Console'
        ];

        $tool_default_dirs = [
            'olla' => $baseDir.'/Operations/Tool'
        ];
        $tool_module_dirs = [];
        $tool_app_dirs = [
            'olla' => $projectDir.'/src/Operations/Tool'
        ];


        $resource_default_dirs = [
            'olla' => $baseDir.'/Resource'
        ];
        $resource_module_dirs = [];
        $resource_app_dirs = [
            'olla' => $projectDir.'/src/Resource',
            'orm' => $projectDir.'/src/Entity'
        ];
     
        if(isset($config['dirs'])) {
            $dirs = $config['dirs'];
            if(isset($dirs['api_default'])) {
                $api_default_dirs = $dirs['api_default'];
            }
            if(isset($dirs['api_module'])) {
                $api_module_dirs = $dirs['api_module'];
            }
            if(isset($dirs['api_app'])) {
                $api_app_dirs = array_merge($api_app_dirs, $dirs['api_app']);
            }
            if(isset($dirs['admin_default'])) {
                $admin_default_dirs = $dirs['admin_default'];
            }
            if(isset($dirs['admin_module'])) {
                $admin_module_dirs = $dirs['admin_module'];
            }
            if(isset($dirs['admin_app'])) {
                $admin_app_dirs = array_merge($admin_app_dirs, $dirs['admin_app']);
            }
            if(isset($dirs['frontend_default'])) {
                $frontend_default_dirs = $dirs['frontend_default'];
            }
            if(isset($dirs['frontend_module'])) {
                $frontend_module_dirs = $dirs['frontend_module'];
            }
            if(isset($dirs['frontend_app'])) {
                $frontend_app_dirs = array_merge($frontend_app_dirs, $dirs['frontend_app']);
            }


            if(isset($dirs['account_default'])) {
                $account_default_dirs = $dirs['account_default'];
            }
            if(isset($dirs['account_module'])) {
                $account_module_dirs = $dirs['account_module'];
            }
            if(isset($dirs['account_app'])) {
                $account_app_dirs = array_merge($account_app_dirs, $dirs['account_app']);
            }

            if(isset($dirs['console_default'])) {
                $console_default_dirs = $dirs['console_default'];
            }
            if(isset($dirs['console_module'])) {
                $console_module_dirs = $dirs['console_module'];
            }
            if(isset($dirs['console_app'])) {
                $console_app_dirs = array_merge($console_app_dirs, $dirs['console_app']);
            }

            if(isset($dirs['tool_default'])) {
                $tool_default_dirs = $dirs['tool_default'];
            }
            if(isset($dirs['tool_module'])) {
                $tool_module_dirs = $dirs['tool_module'];
            }
            if(isset($dirs['tool_app'])) {
                $tool_app_dirs = array_merge($tool_app_dirs, $dirs['tool_app']);
            }


            if(isset($dirs['resource_default'])) {
                $api_default_dirs = $dirs['resource_default'];
            }
            if(isset($dirs['resource_module'])) {
                $resource_module_dirs = $dirs['resource_module'];
            }
            if(isset($dirs['resource_app'])) {
                $resource_app_dirs = array_merge($resource_app_dirs, $dirs['resource_app']);
            }
        }
        $container->setParameter('olla.api_default_dirs', $api_default_dirs);
        $container->setParameter('olla.api_module_dirs', $api_module_dirs);
        $container->setParameter('olla.api_app_dirs', $api_app_dirs);
        $container->setParameter('olla.admin_default_dirs', $admin_default_dirs);
        $container->setParameter('olla.admin_module_dirs', $admin_module_dirs);
        $container->setParameter('olla.admin_app_dirs', $admin_app_dirs);
        $container->setParameter('olla.frontend_default_dirs', $frontend_default_dirs);
        $container->setParameter('olla.frontend_module_dirs', $frontend_module_dirs);
        $container->setParameter('olla.frontend_app_dirs', $frontend_app_dirs);
        $container->setParameter('olla.account_default_dirs', $account_default_dirs);
        $container->setParameter('olla.account_module_dirs', $account_module_dirs);
        $container->setParameter('olla.account_app_dirs', $account_app_dirs);

        $container->setParameter('olla.console_default_dirs', $console_default_dirs);
        $container->setParameter('olla.console_module_dirs', $console_module_dirs);
        $container->setParameter('olla.console_app_dirs', $console_app_dirs);

        $container->setParameter('olla.tool_default_dirs', $tool_default_dirs);
        $container->setParameter('olla.tool_module_dirs', $tool_module_dirs);
        $container->setParameter('olla.tool_app_dirs', $tool_app_dirs);

        $container->setParameter('olla.resource_default_dirs', $resource_default_dirs);
        $container->setParameter('olla.resource_module_dirs', $resource_module_dirs);
        $container->setParameter('olla.resource_app_dirs', $resource_app_dirs);
    }
}
