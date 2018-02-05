<?php

namespace Olla\Prisma\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class Operation {
    /**
     * @var string
     */
	public $id;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $description;
    
    /**
     * @var array
     */
    public $arguments = [];
    /**
     * @var array
     */
    public $permissions = [];
    /**
     * @var array
     */
    public $route = [];

     /**
     * @var array
     */
    public $tags;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $controller;
}
