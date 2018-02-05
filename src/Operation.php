<?php

namespace Olla\Prisma;

use Olla\Prisma\Builder\OperationBuilder;

final class Operation
{
    private $builder;
    public function __construct(
        OperationBuilder $builder
    ) {
        $this->builder = $builder;
    }

    public function collections() {
        return $this->builder->get();
    }
}
