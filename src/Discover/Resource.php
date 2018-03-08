<?php

namespace Olla\Prisma\Discover;

use Olla\Prisma\Annotation\Resource as ResourceAnnotation;
use Composer\Autoload\ClassLoader;
use Symfony\Component\PropertyInfo\Type;

final class Resource extends Discover implements DiscoverInterface
{
    public function classes($name, $cache_dir) {
        $discovers = $this->scanDir($this->app_dir, ['php']);
        $classMap = [];
        $resources = [];
        foreach ($discovers as $className => $classFile) {
            if(null !== $annotation = $this->get($className)) {
                $classMap = array_merge($classMap, [$className => $classFile]);
                $resources[$annotation['id']] = $annotation;
            }
        }
        $this->cached($name, $cache_dir, $classMap);
        return $resources;
    }

    public function collections() {
        $discovers = $this->scanDir($this->app_dir, ['php']);
        $classMap = [];
        $resources = [];
        foreach ($discovers as $className => $classFile) {
            if(null !== $annotation = $this->get($className)) {
                $classMap = array_merge($classMap, [$className => $classFile]);
                $resources[$annotation['id']] = $annotation;
            }
        }
        return $resources;
    }
    public function get(string $className, array $options = []) {
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
        if(!isset($data['id'])) {
            throw new \Exception(sprintf("Resource %s invalid, you need put 'id' on parameters", $className));
        }
        if(!isset($data['class'])) {
            $data['class'] = $className;
        }
        if(!isset($data['alias'])) {
            if (false !== $pos = strrpos($data['class'], '\\')) {
                $data['alias'] = substr($data['class'], $pos + 1);
            }
        }
        if(!isset($data['operations'])) {
            $data['operations'] = [
                'collection' => [],
                'item' => [],
                'create' => [],
                'update' => [],
                'delete' => []
            ];
        }
        if(!isset($data['admins'])) {
            $data['admins'] = [
                'collection' => [],
                'item' => [],
                'item_form' => [],
                'create' => [],
                'update' => [],
                'delete' => []
            ];
        }
        if(isset($data['class']) && !isset($data['properties'])) {
            $data['properties'] = $this->properties($data['class']);
        }
        return $data;
    }
    public function properties(string $className, array $options = []) {
        $properties = $this->propertyInfo->getProperties($className, $options);
        if (null === $properties) {
            throw new \RuntimeException(sprintf('There is no PropertyInfo extractor supporting the class "%s".', $className));
        }
        $fields = [];
        foreach ($properties as $key => $field) {
            $types = $this->propertyInfo->getTypes($className, $field);
            if (!isset($types[0])) {
                continue;
            } 
            $type = $types[0];
            $data = [];
            $data['name'] = $field;
            $data['type'] = $type->getBuiltinType();
            if($type->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT) {
                $isCollection = $type->isCollection();
                $className = $isCollection ? $type->getCollectionValueType()->getClassName() : $type->getClassName();
                $data['class'] = $className;
                $data['collection'] = $isCollection;
            } 
            $data['description'] =  $this->propertyInfo->getShortDescription($className, $field);
            $data['readable'] = $this->propertyInfo->isReadable($className, $field);
            $data['writeable'] = $this->propertyInfo->isWritable($className, $field);
            $fields[$field] = $data;
        }
        return  $fields;
    }
}
