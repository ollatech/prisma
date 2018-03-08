<?php

namespace Olla\Prisma\Operation;

use Olla\Prisma\Annotation\Operation;

/**
 * @Operation(
 * 	   id ="welcome",
 *     path ="/",
 * 	   methods = "GET"
 * )
 */
class Operation
{
    public function __invoke() {
    	return [];
    }
}