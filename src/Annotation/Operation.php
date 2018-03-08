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
    public $version;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $methods = [];

    /**
     * @var string
     */
    public $controller;

    /**
     * @var array
     */
    public $route = [];

    /**
     * @var string
     */
    public $template;

    /**
     * @var string
     */
    public $resource;



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
    public $tags;

    /**
     * @var string
     */
    public $action;

    

    

    /**
     * @var array
     */
    public $assets = [];
    /**
     * @var array
     */
    public $react = [];
    /**
     * @var array
     */
    public $options = [];
}
