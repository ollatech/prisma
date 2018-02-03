<?php

namespace Olla\Prisma\Metadata;

use Olla\Prisma\Metadata\Resource;
use Olla\Prisma\Metadata\Discover\DiscoverInterface;
use Olla\Prisma\Metadata\Factory\FactoryInterface;

final class ResourceBuilder
{
    private $resourceDiscover;
    private $propertyDiscover;
    private $resourceFactory;
    private $propertyFactory;

    public function __construct(
        DiscoverInterface $resourceDiscover,
        DiscoverInterface $propertyDiscover,
        FactoryInterface $resourceFactory,
        FactoryInterface $propertyFactory
    ) {
        $this->resourceDiscover = $resourceDiscover;
        $this->propertyDiscover = $propertyDiscover;
        $this->resourceFactory = $resourceFactory;
        $this->propertyFactory = $propertyFactory;
    }

    public function create(string $resourceClass) {
        if(null === $resourceClass) {
            return;
        }
        if(null === $annotation = $this->resourceDiscover->get($resourceClass)) {
            return null;
        }

        if(null === $resource = $this->resourceFactory->create($annotation)) {
            return null;
        }
        /**
         * Create exception later. for now silently return null
         */
        try {
            $metadata = new Resource(
                $resource['class'],
                $resource['alias'],
                $resource['id'],
                $resource['type']
            );
        } catch (\Exception $e) {
            throw new \Exception('Something went wrong!');
        }
        //create properties
        if(null !== $properties = $this->createProperties($resourceClass)) {
            $metadata->withProperties($properties);
        }
        return $metadata;
    }
    
    private function createProperties(string $resourceClass) {
        if(null === $collections = $this->propertyDiscover->collections($resourceClass)) {
            return [];
        }
        $properties = [];
        foreach ($collections as $property => $type) {
            if(null === $annotation = $this->propertyDiscover->get($resourceClass, $property)) {
                continue;
            }
            if(null !== $value = $this->propertyFactory->create($annotation)) {
                $properties[$property] = $value;
            } 
        }
        return $properties;
    }
}
