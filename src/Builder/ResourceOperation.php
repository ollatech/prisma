<?php

namespace Olla\Prisma\Builder;
use Doctrine\Common\Inflector\Inflector;
final class ResourceOperation {

	protected $settings;

	public function addSetting($setting, $value) {
		$this->settings[$setting] = $value;
		return $this;
	}

	public function create($resource, array $data = []) {
		$maps = [];
		foreach ($resource['operations'] as $action => $op) {
			$resourceAlias = $resource['alias'];
			$resourceClass = $resource['class'];
			$id = $this->id('operation', $action, $resource);
			$operation = [];
			$operation['id'] = $id;
			$operation['alias'] = $this->alias($action, $resource);
			$operation['description'] = '';
			$operation['arguments'] = $this->args($action, $resource);
			$operation['tags'] = $this->tags($action, $resource);
			$operation['action'] = $action;
			$operation['route'] = $this->route($action, $resource);
			$operation['resource'] = $resourceClass;
			$operation['controller'] = $this->settings[$action.'_operation'];
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
			$operation['alias'] = $this->alias($action, $resource);
			$operation['description'] = '';
			$operation['arguments'] = $this->args($action, $resource);
			$operation['tags'] = $this->tags($action, $resource);
			$operation['action'] = $action;
			$operation['route'] = $this->route($action, $resource);
			$operation['resource'] = $resourceClass;
			$operation['controller'] = $this->settings[$action.'_admin'];
			$maps[$id] = $operation;
		}
		return $maps;
	}
	
	private function id($broker, $action, $resource) {
		$resourceAlias = $resource['alias'];
		return strtolower($resourceAlias).'_'.$action.'_'.$broker;
	}
	private function alias($action, $resource) {
		$resourceAlias = $resource['alias'];
		$resourceClass = $resource['class'];
		$singular = strtolower(Inflector::singularize($resourceAlias));
		$plural = strtolower(Inflector::pluralize($resourceAlias));
		switch ($action) {
			case 'collection':
			return $plural;
			break;
			case 'item':
			return $singular;
			break;
			case 'item_form':
			return 'form'.$resourceAlias;
			break;
			case 'create':
			return 'create'.$resourceAlias;
			break;
			case 'update':
			return 'update'.$resourceAlias;
			break;
			case 'delete':
			return 'delete'.$resourceAlias;
			default:
			break;
		}
	}
	private function tags($action, $resource) {
		$resourceAlias = $resource['alias'];
		$resourceClass = $resource['class'];
		$singular = strtolower(Inflector::singularize($resourceAlias));
		$plural = strtolower(Inflector::pluralize($resourceAlias));
		return [$plural];
	}
	private function route($action, $resource) {
		$resourceAlias = $resource['alias'];
		$resourceClass = $resource['class'];
		$singular = strtolower(Inflector::singularize($resourceAlias));
		$plural = strtolower(Inflector::pluralize($resourceAlias));
		switch ($action) {
			case 'collection':
			return [
				'path' => '/'.$plural.'',
				'method' => 'GET',
			];
			break;
			case 'item':
			return [
				'path' => '/'.$plural.'/{id}',
				'method' => 'GET'
			];
			case 'item_form':
			return [
				'path' => '/'.$plural.'/{id}/edit',
				'method' => 'GET'
			];
			break;
			case 'create':
			return [
				'path' => '/'.$plural.'',
				'method' => 'POST'
			];
			break;
			case 'update':
			return [
				'path' => '/'.$plural.'/{id}',
				'method' => 'PUT'
			];
			break;
			case 'delete':
			return [
				'path' => '/'.$plural.'/{id}',
				'method' => 'DELETE'
			];
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