<?php

namespace Olla\Prisma\Metadata;

final class Resource
{
	/**
	 * @var string
	 */
	public $class;

    /**
     * @var string
     */
    public $guard_class;

	/**
	 * @var string
	 */
	public $alias;

	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var string
	 */
	public $type;

	/**
	 * @var array
	 */
	public $properties;

	/**
	 * @var array
	 */
	public $operations;

	/**
	 * @var array
	 */
	public $admins;

	/**
	 * @var array
	 */
	public $frontends;

	/**
	 * @var array
	 */
	public $subscriptions;

	/**
	 * @var array
	 */
	public $graphqlTypes;

	/**
	 * @var array
	 */
	public $access;

	public function __construct(string $class, string $alias, string $id = null, string $type = 'data') {
		$this->class = $class;
		$this->alias = $alias;
		$this->id = $id;
		$this->type = $type;
	}

	/**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    /**
     * @return string
     */
    public function getGuardClass()
    {
        return $this->guard_class;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return array
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * @return array
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * @return array
     */
    public function getFrontends()
    {
        return $this->frontends;
    }

    /**
     * @return array
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @return array
     */
    public function getGraphqlTypes()
    {
        return $this->graphqlTypes;
    }

    /**
     * @return array
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param array $properties
     *
     * @return self
     */
    public function withGuard($guard_class)
    {
        $this->guard_class = $guard_class;
        return $this;
    }
    

    /**
     * @param array $properties
     *
     * @return self
     */
    public function withProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

   

    /**
     * @param array $operations
     *
     * @return self
     */
    public function withOperations(array $operations)
    {
        $this->operations = $operations;

        return $this;
    }

    

    /**
     * @param array $admins
     *
     * @return self
     */
    public function withAdmins(array $admins)
    {
        $this->admins = $admins;

        return $this;
    }

    

    /**
     * @param array $frontends
     *
     * @return self
     */
    public function withFrontends(array $frontends)
    {
        $this->frontends = $frontends;

        return $this;
    }

   

    /**
     * @param array $subscriptions
     *
     * @return self
     */
    public function withSubscriptions(array $subscriptions)
    {
        $this->subscriptions = $subscriptions;

        return $this;
    }

    

    /**
     * @param array $graphqlTypes
     *
     * @return self
     */
    public function withGraphqlTypes(array $graphqlTypes)
    {
        $this->graphqlTypes = $graphqlTypes;

        return $this;
    }

    /**
     * @param array $access
     *
     * @return self
     */
    public function withAccess(array $access)
    {
        $this->access = $access;

        return $this;
    }
}
