<?php

namespace Olla\Prisma\Builder;

use Olla\Prisma\Builder\ResourceOperation;
use Olla\Prisma\Discover\DiscoverInterface;
use Olla\Prisma\Factory\FactoryInterface;
use Doctrine\Common\Inflector\Inflector;

final class AccountBuilder extends OperationBuilder
{
    private $operationDiscover;
    private $resourceDiscover;
    private $operationFactory;
    private $resourceOperation;
    private $operations;


    public function __construct(
        DiscoverInterface $operationDiscover,
        DiscoverInterface $resourceDiscover,
        FactoryInterface $operationFactory,
        ResourceOperation $resourceOperation
    ) {
        $this->operationDiscover = $operationDiscover;
        $this->resourceDiscover = $resourceDiscover;
        $this->operationFactory = $operationFactory;
        $this->resourceOperation = $resourceOperation;
    }
   
    
    public function create($annotation, array $options = []) {
        return $this->operationFactory->create($annotation, $options);
    }
    public function get() {
        $maps = [];
        foreach ($this->operationDiscover->collections() as $opId => $annotation) {
            if(null !== $operation = $this->create($annotation)) {
                $maps[$opId] = $operation;
            } 
        }  
        return $maps; 
    }
    public function find($operationId) {
        $operations = $this->get();
        if(isset($operations[$operationId])) {
            return $operations[$operationId];
        }
    }
}
