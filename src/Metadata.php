<?php

namespace Olla\Prisma;

use Olla\Prisma\Resource;
use Olla\Prisma\Operation;
use Olla\Prisma\MetadataInterface;

final class Metadata implements MetadataInterface
{
    private $resource;
    private $operation;
    private $admin;
    private $frontend;

    public function __construct(
        Resource $resource,
        Operation $operation,
        Admin $admin,
        Frontend $frontend
    ) {
        $this->resource = $resource;
        $this->operation = $operation;
        $this->admin  = $admin;
        $this->frontend = $frontend;
    }

    public function resources() {
        return $this->resource->collections();
    }

    public function resource(string $resourceClass) {
        return $this->builder->create($resourceClass);
    }
    public function operations() {
        return $this->operation->collections();
    }
    public function admins() {
        return $this->admin->collections();
    }
    public function frontends() {
        return $this->frontend->collections();
    }
}
