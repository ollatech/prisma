<?php

namespace Olla\Prisma;

use Olla\Prisma\Builder\AdminBuilder;

final class Admin
{
    private $builder;
    public function __construct(
        AdminBuilder $builder
    ) {
        $this->builder = $builder;
    }

    public function collections() {
        return $this->builder->get();
    }
    public function find(string $operationId) {
        return $this->builder->find($operationId);
    }
}
