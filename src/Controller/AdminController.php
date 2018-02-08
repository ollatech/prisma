<?php

namespace Olla\Prisma\Controller;

use Olla\Flow\Gate;
use Olla\Flow\Theme;
use Olla\Prisma\MetadataInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class AdminController extends Controller
{
    protected $gate;
	protected $theme;
	protected $metadata;
    protected $container;
    protected $controller;

    public function __construct(MetadataInterface $metadata, ContainerInterface $container, Theme $theme, Gate $gate) {
        $this->metadata = $metadata;
        $this->container = $container;
        $this->theme = $theme;
        $this->gate = $gate;
    }

    public function __invoke(Request $request) {
        
        if(null === $operationId = $request->attributes->get('_operation')) {
            return $this->errors(['operation' => 'invalid operation']);
        }
        if(null === $operation = $this->metadata->admin($operationId)) {
            return $this->errors(['operation' => 'invalid operation, cant find operation']);
        }
        if(null !== $controller = $this->operation($operation->getController())) {
            $template = sprintf('%s.html.twig', $operationId);
            $data = [];
            if (is_callable($controller))
            {
                $data = call_user_func_array($controller, [$request]);
            }
            if(!is_array($data)) {
                $data = [];
            }
            return $this->theme->context('admin')->design('default')->render($template, $data);
        }
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Unidentifined error'
        ]);
    }
}