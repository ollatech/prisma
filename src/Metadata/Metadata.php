<?php

namespace Olla\Prisma\Metadata;

use Olla\Prisma\Metadata\Discover\DiscoverInterface;
use Olla\Prisma\Metadata\Factory\FactoryInterace;

final class Metadata implements MetadataInterface
{
    private $builder;
    private $adminDiscover;
    private $frontendDiscover;
    private $graphqlTypeDiscover;
    private $operationDiscover;
    private $resourceDiscover;
    private $subscriptionDiscover;
    private $propertyDiscover;

    public function __construct(
        Builder $builder,
        DiscoverInterface $adminDiscover,
        DiscoverInterface $frontendDiscover,
        DiscoverInterface $graphqlTypeDiscover,
        DiscoverInterface $operationDiscover,
        DiscoverInterface $resourceDiscover,
        DiscoverInterface $subscriptionDiscover,
        DiscoverInterface $propertyDiscover
    ) {
        $this->builder = $builder;
        $this->adminDiscover = $adminDiscover;
        $this->frontendDiscover = $frontendDiscover;
        $this->graphqlTypeDiscover = $graphqlTypeDiscover;
        $this->operationDiscover = $operationDiscover;
        $this->resourceDiscover = $resourceDiscover;
        $this->subscriptionDiscover = $subscriptionDiscover;
        $this->propertyDiscover = $propertyDiscover;
    }

   
    public function resources() {
       $resources =  $this->resourceDiscover->collections();
       $metadatas = [];
       foreach ($resources as $key => $className) {
            $resource = $this->builder->create($className);
            $metadatas[$className] = $resource;
       }
       return $metadatas;
    }
    public function resource(string $resourceClass) {
       return $this->builder->create($resourceClass);
    }
}
