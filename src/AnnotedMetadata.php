<?php

namespace Olla\Prisma;

use Olla\Prisma\Resource;
use Olla\Prisma\Operation;
use Olla\Prisma\Builder\FrontendBuilder;
use Olla\Prisma\Builder\AdminBuilder;
use Olla\Prisma\Builder\OperationBuilder;
use Olla\Prisma\Builder\ResourceBuilder;

final class AnnotedMetadata implements Metadata, MetadataInterface
{
    private $resource;
    private $operation;
    private $admin;
    private $frontend;
    
    public function __construct(
        ResourceBuilder $resource,
        OperationBuilder $operation,
        AdminBuilder $admin,
        FrontendBuilder $frontend
    ) {
        $this->resource = $resource;
        $this->operation = $operation;
        $this->admin  = $admin;
        $this->frontend = $frontend;
    }

    public function resources() {
        return $this->resource->get();
    }

    public function resource(string $resourceClass) {
        return $this->builder->create($resourceClass);
    }
    public function operations() {
        return $this->operation->get();
    }
    public function operation(string $operationId) {
        return $this->operation->find($operationId);
    }
    public function admins() {
        return $this->admin->get();
    }
    public function admin(string $operationId) {
        return $this->admin->find($operationId);
    }
    public function frontends() {
        return $this->frontend->get();
    }
    public function frontend(string $operationId) {
        return $this->frontend->find($operationId);
    }
}