<?php

namespace Olla\Prisma\Operation\Admin;

use Olla\Core\Operation\MultiOperation;
use Olla\Core\Operation\ViewOperation;
use Olla\Core\Operation\ApiOperation;
use Olla\Prisma\Annotation\Operation;

/**
 * @Operation(
 * 	   id ="dashboard",
 *     path = "/",
 *     methods = "GET",
 * 	   template = "dashboard.html.twig",
 * 	   react = {
 * 			"js" = "frontend.js",
 * 			"component" = "app"
 * 	   }
 * )
 */
class Dashboard extends ViewOperation
{
    public function http() {
    	return $this->view('', []);
    }
}