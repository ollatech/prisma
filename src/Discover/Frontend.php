<?php

namespace Olla\Prisma\Discover;
use Olla\Prisma\Annotation\Operation as OperationAnnotation;
use Composer\Autoload\ClassLoader;

final class Frontend  extends Discover implements DiscoverInterface
{
    protected $reader;
    protected $serializer;
    protected $propertyInfo;
    protected $paths;

    public function classes($name, $cache_dir) {
        $classMap = [];
        foreach ($this->operations() as $id => $op) {
            $classMap = array_merge($classMap, [$op['namespace'] => $op['path']]);
        }
        $this->classAutoload($classMap);
        $this->cached($name, $cache_dir, $classMap);
    }

    public function collections() {
        $resources = [];
        foreach ($this->operations() as $id => $op) {
            if(null !== $annotation = $this->get($op['namespace'])) {
                $resources[$annotation['id']] = $annotation;
            }
        }
        print_r($resources);
        return $resources;
    }

   
  

    public function get($className, array $options = []) {
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
        if(!isset($data['id'])) {
            throw new \Exception(sprintf("Operation class %s invalid, you need put 'id' on parameters", $className));
        }
        if(!isset($data['alias'])) {
            throw new \Exception(sprintf("Operation class %s invalid, you need put 'alias' on parameters", $className));
        }
        if(!isset($data['route'])) {
            throw new \Exception(sprintf("Operation class %s invalid, you need put 'route' on parameters", $className));
        }
        if(!isset($data['permissions'])) {
            $data['permissions'] = ['public'];
        }
        if(!isset($data['tags'])) {
            $data['tags'] = ['custom'];
        }
        if(!isset($data['action'])) {
            $data['action'] = 'custom';
        }
        if(!isset($data['resource'])) {
            $data['resource'] = '';
        }
        if(!isset($data['controller'])) {
            $data['controller'] = $className;
        }
        return $data;
    }
}
