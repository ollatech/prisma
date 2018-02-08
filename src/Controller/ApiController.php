<?php

namespace Olla\Prisma\Controller;

use Olla\Flow\Gate;
use Olla\Flow\Conneg;
use Olla\Prisma\MetadataInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ApiController extends Controller
{
    protected $gate;
	protected $conneg;
    protected $container;
    protected $controller;

    public function __construct(MetadataInterface $metadata, ContainerInterface $container, Conneg $conneg, Gate $gate) {
        $this->metadata = $metadata;
        $this->container = $container;
        $this->conneg = $conneg;
        $this->gate = $gate;
    }

    public function __invoke(Request $request) {
        
        if(null === $operationId = $request->attributes->get('_operation')) {
            return $this->errors(['operation' => 'invalid operation']);
        }
        if(null === $operation = $this->metadata->operation($operationId)) {
            return $this->errors(['operation' => 'invalid operation, cant find operation']);
        }
        if(null !== $controller = $this->operation($operation->getController())) {
            $data = [];
            if (is_callable($controller))
            {
                $data = call_user_func_array($controller, [$request]);
            }
            if(!is_array($data)) {
                $data = [];
            }
            return $this->conneg->request($request)->data($data)->response();
        }
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Unidentifined error'
        ]);
    }
}