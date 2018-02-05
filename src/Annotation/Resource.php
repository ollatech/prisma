<?php

namespace Olla\Prisma\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class Resource {

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
    public $operations;

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
    public $translateable;
}
