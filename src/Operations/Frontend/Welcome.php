<?php

namespace Olla\Prisma\Operation\Frontend;

use Olla\Prisma\Annotation\Operation;

/**
 * @Operation(
 * 	   id ="welcome",
 *     path ="/",
 * 	   methods = "GET",
 * 	   template = "frontend/welcome.html.twig"
 * )
 */
class Welcome
{
    public function __invoke() {
    	return [];
    }
}