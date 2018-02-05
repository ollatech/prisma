<?php
namespace Olla\Prisma\Route;

use Olla\Prisma\MetadataInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\Loader;


final class GraphqlRoute extends Loader
{
	private $metadata;
	private $controller = 'Olla\Prisma\Placeholder\Controller';
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
		$routeCollection = new RouteCollection();
		$route = [];
		$route['_controller'] = $this->controller;
		$routeCollection->add(
			'olla_prisma_graphql', 
			new Route(
				'', 
				$route+[],
				[],
				[],
				'',
				[],
				'POST',
				''
			));
		return $routeCollection;
	}

	public function supports($resource, $type = null)
	{
		return 'olla_graphql' === $type;
	}	
}
