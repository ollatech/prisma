<?php

namespace Olla\Prisma\Metadata;

use Olla\Prisma\Metadata\Discover\DiscoverInterface;
use Olla\Prisma\Config;
use Doctrine\Common\Inflector\Inflector;

final class Source
{
    protected $resource_class;
    private $resourceDiscover;
    private $propertyDiscover;

    public function __construct(
        DiscoverInterface $resourceDiscover,
        DiscoverInterface $propertyDiscover
    ) {
       
        $this->resourceDiscover = $resourceDiscover;
        $this->propertyDiscover = $propertyDiscover;
    }

    public function operations(string $resourceClass) {
        $this->resource_class = $resourceClass;
        if(null === $resourceClass) {
            return;
        }
        if(null === $resource = $this->resourceDiscover->get($resourceClass)) {
            return null;
        }
        
        $properties = $this->properties($resourceClass);
        $actions = ['collection','item','create','update','delete'];
        $baseId = strtolower($resource['alias']).'_%s_operation';
   
        $operations = [];
        foreach ($actions as $key => $action) {
            $operation = [];
            $id = sprintf($baseId, $action);
            $operation['id'] = $id;
            $operation['class'] = '';
            $operation['alias'] = $this->buildAlias($action, $resource['alias']);
            $operation['action'] = $action;
            $operation['type'] = $this->buildType($action);
            $operation['args'] = $this->buildArgs($action, $properties, $resource);
            $operation['access'] = $this->buildAccess($action, $resource);
            $operation['route'] = $this->buildRoute($action, $resource['alias']);
            $operations[$id] = $operation;
        }
        return $operations;
    }
    public function admins(string $resourceClass) {
        $this->resource_class = $resourceClass;
        if(null === $resourceClass) {
            return;
        }
        if(null === $resource = $this->resourceDiscover->get($resourceClass)) {
            return null;
        }
        
        $properties = $this->properties($resourceClass);
        $actions = ['collection','item','item_form','create','update','delete'];
        $baseId = strtolower($resource['alias']).'_%s_admin';
        $baseAlias = '%s'.$resource['alias'];
        $operations = [];
        foreach ($actions as $key => $action) {
            $operation = [];
            $id = sprintf($baseId, $action);
            $operation['id'] = $id;
            $operation['class'] = '';
            $operation['alias'] = $this->buildAlias($action, $resource['alias']);
            $operation['action'] = $action;
            $operation['type'] = $this->buildType($action);
            $operation['args'] = $this->buildArgs($action, $properties, $resource); 
            $operation['access'] = $this->buildAccess($action, $resource);
            $operation['route'] = $this->buildRoute($action, $resource['alias']);
            $operations[$id] = $operation;
        }
        return $operations;
    }
    private function buildAlias($action, $alias) {
        $singular = strtolower(Inflector::singularize($alias));
        $plural = strtolower(Inflector::pluralize($alias));
        switch ($action) {
            case 'collection':
            return $plural;
            break;
            case 'item':
            return $singular;
            break;
            case 'item_form':
            return 'form'.$alias;
            break;
            case 'create':
            return 'create'.$alias;
            break;
            case 'update':
            return 'update'.$alias;
            break;
            case 'delete':
            return 'delete'.$alias;
            default:
            break;
        }
    }
    private function buildType($action) {
        switch ($action) {
            case 'collection':
            return 'query';
            break;
            case 'item':
            return 'query';
            break;
            case 'item_form':
            return 'query';
            break;
            case 'create':
            return 'mutation';
            break;
            case 'update':
            return 'mutation';
            break;
            case 'delete':
            return 'mutation';
            default:
            break;
        }
    }
    private function properties(string $resourceClass) {
        if(null === $collections = $this->propertyDiscover->collections($resourceClass)) {
            return [];
        }
        $properties = [];
        foreach ($collections as $property => $type) {
            if(null === $annotation = $this->propertyDiscover->get($resourceClass, $property)) {
                continue;
            }
            $properties[$property] = $annotation;
        }
        return $properties;
    }

   
    private function buildArgs($action,  $properties, $resource) {
        
        switch ($action) {
            case 'collection':

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
    private function buildRoute($action, $resourceAlias) {
        $singular = Inflector::singularize($resourceAlias);
        $plural = strtolower(Inflector::pluralize($resourceAlias));
        switch ($action) {
            case 'collection':
            return [
                'path' => '/'.$plural.'',
                'method' => 'GET'
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
    private function buildAccess($action, $annotation) {
        switch ($action) {
            case 'collection':
            break;
            case 'item':
            break;
            case 'create':
            break;
            case 'update':
            break;
            case 'delete':
            default:
            break;
        }
    }
}
