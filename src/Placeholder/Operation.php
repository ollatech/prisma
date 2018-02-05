<?php

namespace Olla\Prisma\Placeholder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Operation
{
   
    public function __invoke() {
        return new JsonResponse([
        	'status' => 'error',
        	'message' => 'No controller'
        ]);
    }
}