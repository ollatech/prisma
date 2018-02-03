<?php

namespace Olla\Prisma\Metadata\Discover;

use Composer\Autoload\ClassLoader;

final class Operation extends Discover implements DiscoverInterface
{
    
     public function collections() {
        $discovers = $this->scanDir($this->paths, ['php']);
        $classMap = [];
        $resources = [];
        foreach ($discovers as $className => $classFile) {
            $classMap = array_merge($classMap, [$className => $classFile]);
            $resources[] = $className;
        }
        $this->classAutoload($classMap);
        return $resources;
    }
    public function get($className, array $options = []) {
        if($options) {
            return $options;
        }
    }
}
