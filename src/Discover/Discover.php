<?php

namespace Olla\Prisma\Discover;

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;


abstract class Discover
{
    protected $reader;
    protected $serializer;
    protected $propertyInfo;
    protected $paths;

    public function __construct(Reader $reader, SerializerInterface $serializer,  PropertyInfoExtractorInterface $propertyInfo) {
        $this->reader =  $reader;
        $this->serializer = $serializer;
        $this->propertyInfo = $propertyInfo;
    }
    
    public function addPath($paths) {
        $this->paths = $paths;
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
    
    protected function scanDir(array $directories)
    {
        foreach ($directories as $path) {
            $iterator = new \RegexIterator(
                new \RecursiveIteratorIterator(
                  new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
                  \RecursiveIteratorIterator::LEAVES_ONLY
              ),
                '/^.+\.php$/i',
                \RecursiveRegexIterator::GET_MATCH
            );
            foreach ($iterator as $file) {
                $sourceFile = $file[0];
                if (!preg_match('(^phar:)i', $sourceFile)) {
                    $sourceFile = realpath($sourceFile);
                }
                require_once $sourceFile;
                $includedFiles[$sourceFile] = true;
            }
        }
        $classes = [];
        $declared = get_declared_classes();
        foreach ($declared as $className) {
            $reflectionClass = new \ReflectionClass($className);
            $sourceFile = $reflectionClass->getFileName();
            if (isset($includedFiles[$sourceFile])) {
                $classes[$className] = $sourceFile;
            } 
        }
        return $classes;
    }
}
