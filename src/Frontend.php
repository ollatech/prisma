<?php

namespace Olla\Prisma;

use Olla\Prisma\Builder\FrontendBuilder;

final class Frontend
{
    private $builder;
    public function __construct(
        FrontendBuilder $builder
    ) {
        $this->builder = $builder;
    }

    public function collections() {
        return $this->builder->get();
    }
}
