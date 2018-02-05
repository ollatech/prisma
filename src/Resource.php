<?php

namespace Olla\Prisma;

use Olla\Prisma\Builder\ResourceBuilder;

final class Resource
{
    private $builder;
    public function __construct(
        ResourceBuilder $builder
    ) {
        $this->builder = $builder;
    }

    public function collections() {
        return $this->builder->get();
    }
}
