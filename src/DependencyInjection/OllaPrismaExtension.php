<?php

namespace Olla\Prisma\DependencyInjection;


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
        $container->setParameter('prisma_resource_paths', $config['mapping']['resource_paths']);
        $container->setParameter('prisma_operation_paths', $config['mapping']['operation_paths']);
        $container->setParameter('prisma_admin_paths', $config['mapping']['admin_paths']);
        $container->setParameter('prisma_frontend_paths', $config['mapping']['frontend_paths']);
        $container->setParameter('prisma_type_paths', $config['mapping']['type_paths']);
        $container->setParameter('prisma_subscription_paths', $config['mapping']['subscription_paths']);
    }
}
