<?php

namespace Olla\Prisma\Discover;

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Olla\Prisma\Annotation\Operation as OperationAnnotation;

abstract class Discover
{
    protected $reader;
    protected $serializer;
    protected $propertyInfo;
    protected $paths;
    protected $cache_dir;
    protected $default_dir;
    protected $module_dir;
    protected $app_dir;

    public function __construct(Reader $reader, SerializerInterface $serializer,  PropertyInfoExtractorInterface $propertyInfo, $defaultDir = [], $moduleDir = [], $appDir = []) {
        $this->reader =  $reader;
        $this->serializer = $serializer;
        $this->propertyInfo = $propertyInfo;
        $this->default_dir = $defaultDir;
        $this->module_dir = $moduleDir;
        $this->app_dir = $appDir;
    }

    public function operations() {
        return array_merge($this->defaultOperations(), $this->moduleOperations(), $this->appOperations());
    }

    public function defaultOperations()
    {
        $resources = [];
        $discovers = $this->scanDir($this->default_dir, ['php']);
        foreach ($discovers as $className => $classFile) {
            if(null !== $annotation = $this->getOperation($className)) {
                $resources[$annotation['url']] = array_merge($annotation, ['path' => $classFile]);
            }
        }
        return $resources;
    }
    public function moduleOperations() {
        $resources = [];
        $discovers = $this->scanDir($this->module_dir, ['php']);
        foreach ($discovers as $className => $classFile) {
            if(null !== $annotation = $this->getOperation($className)) {
                $resources[$annotation['url']] = array_merge($annotation, ['path' => $classFile]);
            }
        }
        return $resources;
    }

    public function appOperations() {
        $resources = [];
        $discovers = $this->scanDir($this->app_dir, ['php']);
        foreach ($discovers as $className => $classFile) {
            if(null !== $annotation = $this->getOperation($className)) {
                $resources[$annotation['url']] = array_merge($annotation, ['path' => $classFile]);
            }
        }
        return $resources;
    }

    public function getOperation($className) {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (\ReflectionException $reflectionException) {
            return null;
        }
        $annotation = $this->reader->getClassAnnotation($reflectionClass, OperationAnnotation::class);
        if(!$annotation) {
            return null;
        }
        $data = json_decode($this->serializer->serialize($annotation, 'json'), true);
        if(!isset($data['id']) || !isset($data['path']) || !isset($data['methods'])) {
            return null;
        }
        return [
            'url' => json_encode($data['methods']).$data['path'],
            'id' => $data['id'],
            'namespace' => isset($data['className']) ? $data['className'] : $className
        ];
    }


    public function addCacheDir($dir) {
        $this->cache_dir = $dir;
    }
    
    public function addPath($paths) {
        $this->paths = $paths;
    }
    public function cached($name, $cache_dir, $classMap, $warmup = true) {
        $mapPath = $cache_dir.'/'.$name.'.map';
        $content = "<?php\nreturn ".var_export($classMap, true).';';
        $this->createFile($mapPath, $content);
        return $classMap;
    }

    protected function createFile($path, $content, $overwrite = true) {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        file_put_contents($path, $content);
        chmod($path, 0664);
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
            $dir = dirname($path);
            if (!is_dir($path)) {
                continue;
                //mkdir($path, 0775, true);
            }
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
