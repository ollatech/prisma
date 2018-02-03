<?php

namespace Olla\Prisma\Metadata\Discover;

use Composer\Autoload\ClassLoader;
use Symfony\Component\PropertyInfo\Type;

final class Property extends Discover implements DiscoverInterface
{

	public function collections(string $className, array $options = []) {
		$properties = $this->propertyInfo->getProperties($className, $options);
		if (null === $properties) {
			throw new \RuntimeException(sprintf('There is no PropertyInfo extractor supporting the class "%s".', $className));
		}
		$fields = [];
		foreach ($properties as $key => $field) {
			$fields[$field] = $field;
		}
		return  $fields;
	}
	public function get(string $className, string $property, array $default = []) {
		$types = $this->propertyInfo->getTypes($className, $property);
		if (!isset($types[0])) {
			return;
		} 
		$type = $types[0];
		$data = [];
		$data['name'] = $property;
		$data['type'] = $types[0]->getBuiltinType();
		$data['description'] =  $this->propertyInfo->getShortDescription($className, $property);
		$data['readable'] = $this->propertyInfo->isReadable($className, $property);
		$data['writable'] = $this->propertyInfo->isWritable($className, $property);
		if($type->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT) {
			$isCollection = $type->isCollection();
			$className = $isCollection ? $type->getCollectionValueType()->getClassName() : $type->getClassName();
			$data['class'] = $className;
			$data['collection'] = $isCollection;
		}
		return $data;
	}

	private function type(string $className, string $field, array $options = []) {
		$types = $this->propertyInfo->getTypes($className, $field, $options);
		$description = $this->propertyInfo->getShortDescription($className, $field, $options);

		if (isset($types[0]) && null !== $type = $this->convertType($types[0])) {
			return  [
				'name' => $field,
				'type' => $type,
				'description' => $description
			];
		} 
	}
	private function convertType($type) {
		$name = null;
		$description = null;
		$className = null;
		$alias = null;
		$group = 'internal';
		switch ($type->getBuiltinType()) {
			case Type::BUILTIN_TYPE_OBJECT:
			$isCollection = $type->isCollection();
			$className = $isCollection ? $type->getCollectionValueType()->getClassName() : $type->getClassName();
			if (is_a($className, \DateTimeInterface::class, true)) {
				$name = Type::BUILTIN_TYPE_STRING;
				break;
			} 
			try {
				$reflectionClass = new \ReflectionClass($className);
			} catch (\ReflectionException $reflectionException) {
			}

			break;
			default:
			$name = $type->getBuiltinType();
		}
		if($name) {
			return [
				'name' => $name,
				'description' => $description,
				'className' => $className,
				'alias' => $alias,
				'group' => $group
			];
		}
	}
}
