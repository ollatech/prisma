<?php

namespace Olla\Prisma\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class Resource {
	/**
     * Operation Name
     * @var string
     */
    public $type;
    
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
    public $customOperations;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     */
    public $translation = [];

    /**
     * @var array
     */
    public $access = [];

    /**
     * @var array
     */
    public $serializer = [];
}
