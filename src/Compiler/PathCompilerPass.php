<?php

namespace Olla\Prisma\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


final class PathCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if($container->hasDefinition('Olla\Prisma\Metadata\Discover\Resource')) {
            $discover = $container->findDefinition('Olla\Prisma\Metadata\Discover\Resource');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_resource_paths')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Metadata\Discover\Operation')) {
            $discover = $container->findDefinition('Olla\Prisma\Metadata\Discover\Operation');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_operation_paths')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Metadata\Discover\Admin')) {
            $discover = $container->findDefinition('Olla\Prisma\Metadata\Discover\Admin');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_admin_paths')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Metadata\Discover\Frontend')) {
            $discover = $container->findDefinition('Olla\Prisma\Metadata\Discover\Frontend');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_frontend_paths')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Metadata\Discover\Subscription')) {
            $discover = $container->findDefinition('Olla\Prisma\Metadata\Discover\Subscription');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_subscription_paths')]
            );
        }
        if($container->hasDefinition('Olla\Prisma\Metadata\Discover\Type')) {
            $discover = $container->findDefinition('Olla\Prisma\Metadata\Discover\Type');
            $discover->addMethodCall(
                'addPath', [$container->getParameter('prisma_type_paths')]
            );
        }
    }
}
