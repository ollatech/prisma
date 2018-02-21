<?php

namespace Olla\Prisma\Annotation;

/**
 * @Annotation
 * @Target({"METHOD", "PROPERTY"})
 */
final class Property {
	/**
     * @var bool
     */
    public $identifier;

     /**
     * @var bool
     */
    public $owner;
    
    /**
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    public $readable;

    /**
     * @var bool
     */
    public $writable;

    /**
     * @var string
     */
    public $filter;

    /**
     * @var string
     */
    public $search;

    /**
     * @var bool
     */
    public $sortable;

    /**
     * @var bool
     */
    public $required;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     */
    public $access = [];

    /**
     * @var array
     */
    public $serializer = [];

    /**
     * @var bool
     */
    public $subresource;

    /**
     * @var int
     */
    public $maxDepth;

    /**
     * @var bool
     */
    public $uploadable;

    /**
     * @var bool
     */
    public $translateable;
}
