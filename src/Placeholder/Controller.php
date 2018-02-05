<?php

namespace Olla\Prisma\Placeholder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Controller
{
    public function __invoke(Request $request) {
        return new JsonResponse([
        	'status' => 'error',
        	'message' => 'No entry point'
        ]);
    }
}