<?php

namespace Olla\Prisma\Bundle\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Filesystem\Filesystem;
use Composer\Autoload\ClassLoader;

final class PathCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $project_dir = $container->getParameter('kernel.project_dir');
        $cache_dir = $project_dir.'/var/prisma';
        $fileSystem = new Filesystem();
        //$fileSystem->remove(array($cache_dir));
        $actionDir = $project_dir.'/src/Actions';

        
        if($container->hasDefinition('olla.resource_discover')) {
            $discover = $container->findDefinition('olla.resource_discover');
            $discover->addMethodCall(
                'classes', ['resource', $cache_dir]
            );
            $classMapFile = $cache_dir.'/resource.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
        }

        if($container->hasDefinition('olla.api_discover')) {
            $discover = $container->findDefinition('olla.api_discover');
            $discover->addMethodCall(
                'classes', ['operation', $cache_dir]
            );
            $classMapFile = $cache_dir.'/operation.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $this->addOperationService($container, $class);
            }
        }

        if($container->hasDefinition('olla.admin_discover')) {
            $discover = $container->findDefinition('olla.admin_discover');
            $discover->addMethodCall(
                'classes', ['admin', $cache_dir]
            );
            $classMapFile = $cache_dir.'/admin.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $this->addOperationService($container, $class);
            }
        }

        if($container->hasDefinition('olla.frontend_discover')) {
            $discover = $container->findDefinition('olla.frontend_discover');
            $discover->addMethodCall(
                'classes', ['frontend', $cache_dir]
            );
            $classMapFile = $cache_dir.'/frontend.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $this->addOperationService($container, $class);
            }
        }

        if($container->hasDefinition('olla.tool_discover')) {
            $discover = $container->findDefinition('olla.tool_discover');
            $discover->addMethodCall(
                'classes', ['tool', $cache_dir]
            );
            $classMapFile = $cache_dir.'/tool.map';
            $classes = file_exists($classMapFile) ? require $classMapFile : [];
            $this->classAutoload($classes);
            foreach ($classes as $class => $file) {
                $this->addOperationService($container, $class);
            }
        }
    }

    protected function addOperationService(ContainerBuilder $container, $class) {
        if(!$container->hasDefinition($class)) {
            $definition = $container->setDefinition($class, new Definition($class));
            $definition->setPublic(true);
            $definition->addTag('olla.operation', ['generated' => true]);
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
