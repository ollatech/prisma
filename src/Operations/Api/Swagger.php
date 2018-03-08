<?php

namespace Olla\Prisma\Operation\Api;

use Olla\Prisma\Annotation\Operation;

/**
 * @Operation(
 * 	   id ="swagger",
 *     path ="/swagger",
 * 	   methods = "GET"
 * )
 */
class Swagger
{
    public function __invoke() {
    	return [];
    }
}