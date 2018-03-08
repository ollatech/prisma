<?php

namespace Olla\Prisma\Builder;

use Doctrine\Common\Inflector\Inflector;

final class ResourceOperation {


	protected $operations;
	public function __construct(array $operations) {
        $this->operations = $operations;
    }


	
	public function createApi($resource, array $data = []) {
		$maps = [];
		foreach ($resource['operations'] as $action => $op) {
			$resourceAlias = $resource['alias'];
			$resourceClass = $resource['class'];
			$id = $this->id('operation', $action, $resource);
			$operation = [];
			$operation['id'] = $id;
			$operation['path'] = $this->path($action, $resourceAlias);
			$operation['methods'] = $this->methods($action, $resourceAlias);
			$operation['action'] = $action;
			$operation['resource'] = $resourceClass;
			$operation['controller'] = $this->operations['api'][$action];
			$operation['executor'] = $this->operations['api'][$action];
			$maps[$id] = $operation;
		}
		return $maps;
	}
	public function createAdmin($resource, array $data = []) {
		$maps = [];
		foreach ($resource['admins'] as $action => $op) {
			$resourceAlias = $resource['alias'];
			$resourceClass = $resource['class'];
			$id = $this->id('admin', $action, $resource);
			$operation = [];
			$operation['id'] = $id;
			$operation['path'] = $this->path($action, $resourceAlias);
			$operation['methods'] = $this->methods($action, $resourceAlias);
			$operation['action'] = $action;
			$operation['resource'] = $resourceClass;
			$operation['controller'] = $this->operations['admin'][$action];
			$operation['executor'] = $this->operations['admin'][$action];
			$maps[$id] = $operation;
		}
		return $maps;
	}
	
	private function id($broker, $action, $resource) {
		$resourceAlias = $resource['alias'];
		return strtolower($resourceAlias).'_'.$action.'_'.$broker;
	}
	private function path($action, $alias) {
		$plural = strtolower(Inflector::pluralize($alias));
		switch ($action) {
			case 'collection':
			return '/'.$plural;
			break;
			case 'item':
			return '/'.$plural.'/{id}';
			case 'item_form':
			return '/'.$plural.'/{id}/edit';
			break;
			case 'create':
			return '/'.$plural;
			break;
			case 'update':
			return '/'.$plural.'/{id}';
			break;
			case 'delete':
			return  '/'.$plural.'/{id}';
			default:
			break;
		}
	}
	private function methods($action, $alias) {
		$plural = strtolower(Inflector::pluralize($alias));
		switch ($action) {
			case 'collection':
			return ['GET'];
			break;
			case 'item':
			return ['GET'];
			case 'item_form':
			return ['GET'];
			break;
			case 'create':
			return ['POST'];
			break;
			case 'update':
			return ['PUT'];
			break;
			case 'delete':
			return  ['DELETE'];
			default:
			break;
		}
	}


	
	private function args($action,  $resource) {

		switch ($action) {
			case 'collection':
			return [
				'keyword' => [
					'type' => 'string'
				],
				'select' => [
					'type' => 'object',
				],
				'page' => [
					'type' => 'int',
				],
				'per_page' => [
					'type' => 'int',
				],
				'sort' => [
					'type' => 'object',
				],
			];
			break;
			case 'item':
			return [
				'id' => [
					'type' => 'string',
					'description' => ''
				]
			];
			break;
			case 'item_form':
			return [
				'id' => [
					'type' => 'string',
					'description' => ''
				]
			];
			break;
			case 'create':
			return [
				'input' => [
					'type' => $resource['class'],
					'group' => 'resource',
					'description' => ''
				]
			];
			break;
			case 'update':
			return [
				'id' => [
					'type' => 'string',
					'description' => ''
				],
				'input' => [
					'type' => $resource['class'],
					'group' => 'resource',
					'description' => ''
				]
			];
			break;
			case 'delete':
			return [
				'id' => [
					'type' => 'string',
					'description' => ''
				]
			];
			break;
			default:
			break;
		}
	}
}