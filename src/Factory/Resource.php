<?php

namespace Olla\Prisma\Factory;
use Olla\Prisma\Values\Resource as ResourceValue;
use Olla\Prisma\Values\Property as PropertyValue;

final class Resource implements FactoryInterface  {
	public function create(array $annt = [], array $opts = []):ResourceValue {
		$rs = new ResourceValue();
		$rs->setId($annt['id']);
		$rs->setDescription($annt['description']);
		$rs->setAlias($annt['alias']);
		$rs->setClass($annt['class']);
		$rs->setAccess($annt['access']);
		$rs->setTranslateable($annt['translateable']);
		$rs->setProperties($this->properties($annt['properties']));
		return $rs;
	}	
	public function properties(array $properties = []) {
		$maps = [];
		foreach ($properties as $name => $property) {
			$maps[$name] = $this->property($property);
		}
		return $maps;
	} 
	public function property($property):PropertyValue {
		$class = isset($property['class']) ? $property['class'] : null;
		$collection = isset($property['collection']) ? $property['collection'] : null;
		$ppt = new PropertyValue();
		$ppt->setName($property['name']);
		$ppt->setReadable($property['readable']);
		$ppt->setWriteable($property['writeable']);
		$ppt->setType($property['type']);
		$ppt->setClassName($class);
		$ppt->setCollection($collection);
		return $ppt;
	}
}
