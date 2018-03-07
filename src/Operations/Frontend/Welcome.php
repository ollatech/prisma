<?php

namespace Olla\Prisma\Operation\Frontend;

use Olla\Prisma\Annotation\Operation;

/**
 * @Operation(
 * 	   id ="welcome",
 *     alias ="welcome",
 *     route = {
 *     		"path" = "/",
 *     		"method" = "GET"
 *     },
 * 	   template = "frontend/welcome.html.twig",
 * 	   react = {
 * 			"js" = "frontend.js",
 * 			"component" = "app"
 * 	   }
 * )
 */
class Welcome
{
    public function __invoke() {
    	return [];
    }
}