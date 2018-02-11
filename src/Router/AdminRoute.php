<?php
namespace Olla\Prisma\Route;

use Olla\Prisma\MetadataInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\Loader;


final class AdminRoute extends Loader
{
	
	private $metadata;
	private $controller = 'Olla\Prisma\Controller';
	public function __construct(MetadataInterface $metadata)
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
		$operations = $this->metadata->admins();
		$routeCollection = new RouteCollection();
		
		foreach ($operations as $opId => $op) {
			$op_route = $op->getRoute();
			$path = isset($op_route['path']) ? $op_route['path']: '/';
			$method = isset($op_route['method']) ? $op_route['method']: null;
			$route = [];
			$route['_controller'] = $this->controller;
			$route['_operation'] = $op->getId();
			$route['_carrier'] = 'admin';
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
		return 'olla_admin' === $type;
	}	
}