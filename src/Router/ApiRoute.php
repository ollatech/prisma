<?php
namespace Olla\Prisma\Router;

use Olla\Prisma\Metadata;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\Loader;


final class ApiRoute extends Loader
{
	private $metadata;
	private $controller = 'Olla\Prisma\Controller';
	public function __construct(Metadata $metadata)
	{
		$this->metadata = $metadata;
	}
	public function addController($controller) {
		$this->controller = $controller;
	}
	
	/**
     * {@inheritdoc}
     */
	public function load($data, $type = null): RouteCollection
	{
		$operations = $this->metadata->operations();
		$routeCollection = new RouteCollection();
		
		foreach ($operations as $opId => $op) {
			$op_route = $op->getRoute();
			$path = isset($op_route['path']) ? $op_route['path'].'.{_format}': '/';
			$method = isset($op_route['method']) ? $op_route['method']: null;
			$route = []; 
			$route['_controller'] = $this->controller;
			$route['_operation'] = $op->getId();
			$route['_carrier'] = 'restapi';
			$route['_format'] = 'json';
			$routeCollection->add($opId, new Route(
				$path, 
				$route+[],
				[],
				[],
				'',
				[],
				$method,
				''));
		}

		return $routeCollection;
	}
	public function supports($resource, $type = null)
	{
		return 'olla_api' === $type;
	}	
}
