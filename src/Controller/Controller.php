<?php

namespace Olla\Prisma\Controller;

use Olla\Prisma\MetadataInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Controller
{
	protected $metadata;
    protected $container;
    protected $controller;
   
	public function __construct(MetadataInterface $metadata, ContainerInterface $container) {
		$this->metadata = $metadata;
        $this->container = $container;
	}

    protected function errors(array $errors = []) {
    	return new JsonResponse([
        	'status' => 'error',
        	'errors' => $errors,
        	'message' => 'Something wrong'
        ]);
    }
    
    protected function operation(string $operationClass) {
        if ($this->container->has($operationClass))
        {
            return $this->container->get($operationClass);
        } 
        throw new \Exception(sprintf("%s not exist on service", $operationClass));
    }

    protected function controller() {
        if ($this->container->has($this->controller))
        {
            return $this->container->get($this->controller);
        } 
        throw new \Exception(sprintf("%s not exist on service", $this->controller));
    }
}