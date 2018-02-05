<?php

namespace Olla\Prisma\Builder;

use Olla\Prisma\Discover\DiscoverInterface;
use Olla\Prisma\Factory\FactoryInterface;

final class ResourceBuilder
{
    private $resourceDiscover;
    private $resourceFactory;

    public function __construct(
        DiscoverInterface $resourceDiscover,
        FactoryInterface $resourceFactory
    ) {
        $this->resourceDiscover = $resourceDiscover;
        $this->resourceFactory = $resourceFactory;
    }

    public function get() {
        $collections = $this->resourceDiscover->collections(); 
        $maps = [];
        foreach ($collections as $rsId => $annotation) {
            if(null !== $resource = $this->create($annotation)) {
                $maps[$rsId] = $resource;
            } 
        } 
        return $maps;  
    }
    public function create($annotation, array $options = []) {
        return $this->resourceFactory->create($annotation, $options);
    }
    public function find(string $resourceId) {
        $resources = $this->collections();
        if(isset($resources[$resourceId])) {
            return $resources[$resourceId];
        }
    }
}
