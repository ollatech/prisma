<?php

namespace Olla\Prisma;

use Olla\Prisma\Resource;
use Olla\Prisma\Operation;
use Olla\Prisma\Builder\FrontendBuilder;
use Olla\Prisma\Builder\AdminBuilder;
use Olla\Prisma\Builder\ApiBuilder;
use Olla\Prisma\Builder\ResourceBuilder;
use Olla\Prisma\Builder\ToolBuilder;

final class AnnotedMetadata implements Metadata, MetadataInterface
{
    private $resource;
    private $operation;
    private $admin;
    private $frontend;
    private $tool;
    
    public function __construct(
        ResourceBuilder $resource,
        ApiBuilder $operation,
        AdminBuilder $admin,
        FrontendBuilder $frontend,
        ToolBuilder $tool
    ) {
        $this->resource = $resource;
        $this->operation = $operation;
        $this->admin  = $admin;
        $this->frontend = $frontend;
        $this->tool = $tool;
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
    public function apis() {
        return $this->operation->get();
    }
    public function api(string $operationId) {
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
    public function tools() {
        return $this->tool->get();
    }
    public function tool(string $operationId) {
        return $this->tool->find($operationId);
    }
}