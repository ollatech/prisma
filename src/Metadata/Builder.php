<?php

namespace Olla\Prisma\Metadata;

use Olla\Prisma\Metadata\Resource;
use Olla\Prisma\Metadata\Discover\DiscoverInterface;
use Olla\Prisma\Metadata\Factory\FactoryInterface;

final class Builder
{
    private $source;
    private $adminDiscover;
    private $frontendDiscover;
    private $graphqlTypeDiscover;
    private $operationDiscover;
    private $resourceDiscover;
    private $subscriptionDiscover;
    private $propertyDiscover;
    private $resourceFactory;
    private $propertyFactory;
    private $operationFactory;
    private $subsciptionFactory;
    private $typeFactory;

    public function __construct(
        Source $source,
        DiscoverInterface $adminDiscover,
        DiscoverInterface $frontendDiscover,
        DiscoverInterface $graphqlTypeDiscover,
        DiscoverInterface $operationDiscover,
        DiscoverInterface $resourceDiscover,
        DiscoverInterface $subscriptionDiscover,
        DiscoverInterface $propertyDiscover,
        FactoryInterface $resourceFactory,
        FactoryInterface $operationFactory,
        FactoryInterface $propertyFactory,
        FactoryInterface $subsciptionFactory,
        FactoryInterface $typeFactory
    ) {
        $this->source = $source;
        $this->adminDiscover = $adminDiscover;
        $this->frontendDiscover = $frontendDiscover;
        $this->graphqlTypeDiscover = $graphqlTypeDiscover;
        $this->operationDiscover = $operationDiscover;
        $this->resourceDiscover = $resourceDiscover;
        $this->subscriptionDiscover = $subscriptionDiscover;
        $this->propertyDiscover = $propertyDiscover;
        $this->resourceFactory = $resourceFactory;
        $this->propertyFactory = $propertyFactory;
        $this->operationFactory = $operationFactory;
        $this->subsciptionFactory = $subsciptionFactory;
        $this->typeFactory = $typeFactory;
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
        if(null !== $guard = $this->createGuard($resourceClass)) {
            $metadata->withGuard($guard);
        }
        if(null !== $properties = $this->createProperties($resourceClass)) {
            $metadata->withProperties($properties);
        }
        if(null !== $operations = $this->createOperations($resourceClass)) {
            $metadata->withOperations($operations);
        }
        if(null !== $admins = $this->createAdmins($resourceClass)) {
            $metadata->withAdmins($admins);
        }
        if(null !== $frontends = $this->createFrontends($resourceClass)) {
            $metadata->withFrontends($frontends);
        }
        return $metadata;
    }
    private function createGuard($annotation) {
        return 'Prisma\Guard\NoGuard';
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

    private function createOperations(string $resourceClass) {
        if(null === $annotation = $this->resourceDiscover->get($resourceClass)) {
            return null;
        }
        $operations = [];
        //create base operations
        $baseOperations = $this->source->operations($resourceClass);
        foreach ($baseOperations as $name => $operationValue) {
            if(null === $annotation = $this->operationDiscover->get(null, $operationValue)) {
                continue;
            }
            $operations[$name] = $this->operationFactory->create($annotation);
        }
        //create custom operations
        if(null === $collections = $this->operationDiscover->collections($resourceClass)) {
            $collections = [];
        }
        foreach ($collections as $className => $classFile) {
            if(null === $annotation = $this->operationDiscover->get($className)) {
                continue;
            }
            $operations[$name] = $this->operationFactory->create($annotation);
        }
        return $operations;
    }
    private function createAdmins(string $resourceClass) {
        if(null === $annotation = $this->resourceDiscover->get($resourceClass)) {
            return null;
        }
        $operations = [];
        //create base operations
        $baseOperations = $this->source->admins($resourceClass);
        foreach ($baseOperations as $name => $operationValue) {
            if(null === $annotation = $this->adminDiscover->get(null, $operationValue)) {
                continue;
            }
            $operations[$name] = $this->operationFactory->create($annotation);
        }
        //create custom operations
        if(null === $collections = $this->adminDiscover->collections($resourceClass)) {
            $collections = [];
        }
        foreach ($collections as $className => $classFile) {
            if(null === $annotation = $this->adminDiscover->get($className)) {
                continue;
            }
            $operations[$name] = $this->operationFactory->create($annotation);
        }
        return $operations;

    }
    private function createFrontends(string $resourceClass) {
        if(null === $annotation = $this->resourceDiscover->get($resourceClass)) {
            return null;
        }
        $operations = [];
       
        //create custom operations
        if(null === $collections = $this->frontendDiscover->collections($resourceClass)) {
            $collections = [];
        }
        foreach ($collections as $className => $classFile) {
            if(null === $annotation = $this->frontendDiscover->get($className)) {
                continue;
            }
            $operations[$name] = $this->frontendFactory->create($annotation);
        }
        return $operations;
    	
    }
    private function createSubscriptions(string $resourceClass) {
        if(null === $annotation = $this->subscriptionDiscover->get($resourceClass)) {
            return null;
        }
        $operations = [];
        //create base operations
        $baseOperations = $this->source->admins($annotation);
        foreach ($baseOperations as $operationName => $operationValue) {
            if(null === $annotation = $this->subscriptionDiscover->get(null, $operationValue)) {
                continue;
            }
            $operations[$name] = $this->subscriptionFactory->create($annotation);
        }
        //create custom operations
        if(null === $collections = $this->subscriptionDiscover->collections($resourceClass)) {
            $collections = [];
        }
        foreach ($collections as $className => $classFile) {
            if(null === $annotation = $this->subscriptionDiscover->get($className)) {
                continue;
            }
            $operations[$name] = $this->subscriptionFactory->create($annotation);
        }
        return $operations;
    	
    }
    private function createGraphqlTypes(string $resourceClass) {
        if(null === $annotation = $this->graphqlTypeDiscover->get($resourceClass)) {
            return null;
        }
        $operations = [];
        //create base operations
       
        //create custom operations
        if(null === $collections = $this->graphqlTypeDiscover->collections($resourceClass)) {
            $collections = [];
        }
        foreach ($collections as $className => $classFile) {
            if(null === $annotation = $this->graphqlTypeDiscover->get($className)) {
                continue;
            }
            $operations[$name] = $this->typeFactory->create($annotation);
        }
        return $operations;
    	
    }
}
