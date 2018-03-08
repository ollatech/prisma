<?php

namespace Olla\Prisma\Bundle\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Composer\Autoload\ClassLoader;

final class PathCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $project_dir = $container->getParameter('kernel.project_dir');
        $cache_dir = $project_dir.'/var/prisma';
        $actionDir = $project_dir.'/src/Actions';

        
        if($container->hasDefinition('Olla\Prisma\Discover\Resource')) {
            $discover = $container->findDefinition('Olla\Prisma\Discover\Resource');
            $appdir = array_merge([ 9999 => $project_dir.'/src/Entity/'], $container->getParameter('prisma_resource_paths'));
            $discover->addMethodCall(
                'addPath', [$appdir]
            );
            $discover->addMethodCall(
                'classes', ['resource', $cache_dir]
            );
            $classMapFile = $cache_dir.'/resource.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
        }

        if($container->hasDefinition('olla.api_discover')) {
            $discover = $container->findDefinition('olla.api_discover');
            $appdir = array_merge([ 9999 => $actionDir.'/Api/'], $container->getParameter('prisma_operation_paths'));
            $discover->addMethodCall(
                'addPath', [$appdir]
            );
            $discover->addMethodCall(
                'classes', ['operation', $cache_dir]
            );
            $classMapFile = $cache_dir.'/operation.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $definition = $container->setDefinition($class, new Definition($class));
                $definition->setPublic(true);
                $definition->addTag('olla.operation', ['generated' => true]);
            }
        }

        if($container->hasDefinition('olla.admin_discover')) {
            $discover = $container->findDefinition('olla.admin_discover');
            $appdir = array_merge([ 9999 => $actionDir.'/Admin/'], $container->getParameter('prisma_admin_paths'));
            $discover->addMethodCall(
                'addPath', [$appdir]
            );
            $discover->addMethodCall(
                'classes', ['admin', $cache_dir]
            );
            $classMapFile = $cache_dir.'/admin.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $definition = $container->setDefinition($class, new Definition($class));
                $definition->setPublic(true);
                $definition->addTag('olla.admin', ['generated' => true]);
            }
        }

        if($container->hasDefinition('olla.frontend_discover')) {
            $discover = $container->findDefinition('olla.frontend_discover');
            $appdir = array_merge([ 9999 => $actionDir.'/Frontend/'], $container->getParameter('prisma_frontend_paths'));
            $discover->addMethodCall(
                'addPath', [$appdir]
            );
            $discover->addMethodCall(
                'classes', ['frontend', $cache_dir]
            );
            $classMapFile = $cache_dir.'/frontend.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $definition = $container->setDefinition($class, new Definition($class));
                $definition->setPublic(true);
                $definition->addTag('olla.frontend', ['generated' => true]);
            }
        }

        //default controller
        if($container->hasDefinition('Olla\Prisma\Builder\ResourceOperation')) {
            $operation = $container->findDefinition('Olla\Prisma\Builder\ResourceOperation');
            $operation->addMethodCall(
                'addSetting', ['collection_operation', $container->getParameter('prisma_collection_operation')]
            );
            $operation->addMethodCall(
                'addSetting', ['item_operation', $container->getParameter('prisma_item_operation')]
            );
            $operation->addMethodCall(
                'addSetting', ['create_operation', $container->getParameter('prisma_create_operation')]
            );
            $operation->addMethodCall(
                'addSetting', ['update_operation', $container->getParameter('prisma_update_operation')]
            );
            $operation->addMethodCall(
                'addSetting', ['delete_operation', $container->getParameter('prisma_delete_operation')]
            );
            $operation->addMethodCall(
                'addSetting', ['collection_admin', $container->getParameter('prisma_collection_admin')]
            );
            $operation->addMethodCall(
                'addSetting', ['item_form_admin', $container->getParameter('prisma_item_form_admin')]
            );
            $operation->addMethodCall(
                'addSetting', ['item_admin', $container->getParameter('prisma_item_admin')]
            );
            $operation->addMethodCall(
                'addSetting', ['create_admin', $container->getParameter('prisma_create_admin')]
            );
            $operation->addMethodCall(
                'addSetting', ['update_admin', $container->getParameter('prisma_update_admin')]
            );
            $operation->addMethodCall(
                'addSetting', ['delete_admin', $container->getParameter('prisma_delete_admin')]
            );
        }

        if($container->hasDefinition('Olla\Prisma\Route\AdminRoute')) {
            $operation = $container->findDefinition('Olla\Prisma\Route\AdminRoute');
            $operation->addMethodCall(
                'addController', [$container->getParameter('prisma_admin_entrypoint')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Route\ApiRoute')) {
            $operation = $container->findDefinition('Olla\Prisma\Route\ApiRoute');
            $operation->addMethodCall(
                'addController', [$container->getParameter('prisma_api_entrypoint')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Route\FrontendRoute')) {
            $operation = $container->findDefinition('Olla\Prisma\Route\FrontendRoute');
            $operation->addMethodCall(
                'addController', [$container->getParameter('prisma_frontend_entrypoint')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Route\GraphqlRoute')) {
            $operation = $container->findDefinition('Olla\Prisma\Route\GraphqlRoute');
            $operation->addMethodCall(
                'addController', [$container->getParameter('prisma_graphql_entrypoint')]
            );
        }
    }

    protected function classAutoload(array $classMap = [])
    {
        if ($classMap) {
            static $mapClassLoader = null;
            if (null === $mapClassLoader) {
                $mapClassLoader = new ClassLoader();
                $mapClassLoader->setClassMapAuthoritative(true);
            } else {
                $mapClassLoader->unregister();
            }
            $mapClassLoader->addClassMap($classMap);
            $mapClassLoader->register();
        }
    }
}
