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
    public $resource_class;

    /**
     * @var string
     */
    public $resource_alias;

    /**
     * @var string
     */
    public $operation_class;

    /**
     * @var string
     */
    public $operation_method;


    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $action;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $path;

    /**
     * @var bool
     */
    public $enabled;

    /**
     * @var array
     */
    public $access = [];

    /**
     * @var array
     */
    public $queries = [];

    /**
     * @var array
     */
    public $filters = [];

    /**
     * @var array
     */
    public $inputs = [];

    /**
     * @var array
     */
    public $context = [];
}
