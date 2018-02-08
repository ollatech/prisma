<?php

namespace Olla\Prisma\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class PathCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $project_dir = $container->getParameter('kernel.project_dir');
        $cache_dir = $project_dir.'/var/prisma';


        if($container->hasDefinition('Olla\Prisma\Discover\Resource')) {
            $discover = $container->findDefinition('Olla\Prisma\Discover\Resource');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_resource_paths')]
            );
            $discover->addMethodCall(
                'classes', ['resource', $cache_dir]
            );
            $classMapFile = $cache_dir.'/resource.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
        }
        if($container->hasDefinition('Olla\Prisma\Discover\Operation')) {
            $discover = $container->findDefinition('Olla\Prisma\Discover\Operation');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_operation_paths')]
            );
            $discover->addMethodCall(
                'classes', ['operation', $cache_dir]
            );
            $classMapFile = $cache_dir.'/operation.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            foreach ($classes as $class => $file) {
                $definition = $container->setDefinition($class, new Definition($class));
                $definition->setPublic(true);
                $definition->addTag('olla.operation', ['generated' => true]);
            }
        }
        if($container->hasDefinition('Olla\Prisma\Discover\Admin')) {
            $discover = $container->findDefinition('Olla\Prisma\Discover\Admin');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_admin_paths')]
            );
            $discover->addMethodCall(
                'classes', ['admin', $cache_dir]
            );
            $classMapFile = $cache_dir.'/admin.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            foreach ($classes as $class => $file) {
                $definition = $container->setDefinition($class, new Definition($class));
                $definition->setPublic(true);
                $definition->addTag('olla.admin', ['generated' => true]);
            }
        }
        if($container->hasDefinition('Olla\Prisma\Discover\Frontend')) {
            $discover = $container->findDefinition('Olla\Prisma\Discover\Frontend');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_frontend_paths')]
            );
            $discover->addMethodCall(
                'classes', ['frontend', $cache_dir]
            );
            $classMapFile = $cache_dir.'/frontend.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
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
}
