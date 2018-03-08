<?php

namespace Olla\Prisma\Operation\Admin;

use Olla\Prisma\Annotation\Operation;

/**
 * @Operation(
 * 	   id ="dashboard",
 *     path ="/",
 * 	   methods = "GET",
 * 	   template = "admin/dashboard.html.twig"
 * )
 */
class Dashboard
{
    public function __invoke() {
    	return [];
    }
}