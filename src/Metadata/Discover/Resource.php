<?php

namespace Olla\Prisma\Metadata\Discover;

use Olla\Prisma\Annotation\Resource as ResourceAnnotation;
use Composer\Autoload\ClassLoader;

final class Resource extends Discover implements DiscoverInterface
{
   
   public function collections() {
        $discovers = $this->scanDir($this->paths, ['php']);
        $classMap = [];
        $resources = [];
        foreach ($discovers as $className => $classFile) {
            if(null !== $resource = $this->get($className)) {
                $classMap = array_merge($classMap, [$className => $classFile]);
                $resources[] = $className;
            }
        }
        return $resources;
    }
    public function get(string $className, array $default = []) {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (\ReflectionException $reflectionException) {
            return null;
        }
        $annotation = $this->reader->getClassAnnotation($reflectionClass, ResourceAnnotation::class);

        if(!$annotation) {
            return null;
        }
        $data = json_decode($this->serializer->serialize($annotation, 'json'), true);
        if(!isset($data['class'])) {
            $data['class'] = $className;
        }
        if(!isset($data['name'])) {
            if (false !== $pos = strrpos($className, '\\')) {
                $data['name'] = substr($className, $pos + 1);
            }
        }
        if(!isset($data['description'])) {
            $data['description'] = "Resource metadata";
        }
        if(!isset($data['alias'])) {
            if (false !== $pos = strrpos($className, '\\')) {
                $data['alias'] = substr($className, $pos + 1);
            }
        }
        if(!isset($data['type'])) {
            if (false !== $pos = strrpos($className, '\\')) {
                $data['type'] = substr($className, $pos + 1);
            }
        }
        return $data;
    }
}
