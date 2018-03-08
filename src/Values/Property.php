<?php

namespace Olla\Prisma\Values;

final class Property
{
   public $name;
   public $type;
   public $writeable;
   public $readable;
   public $nullable;
   public $subresource;
   public $className;
   public $collection;
   public $translateable;
   public $access;


    public function __construct(array $data)
    {
        if (isset($data['value'])) {
            $data['path'] = $data['value'];
            unset($data['value']);
        }

        foreach ($data as $key => $value) {
            $method = 'set'.str_replace('_', '', $key);
            if (!method_exists($this, $method)) {
                continue;
            }
            $this->$method($value);
        }
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWriteable()
    {
        return $this->writeable;
    }

    /**
     * @param mixed $writeable
     *
     * @return self
     */
    public function setWriteable($writeable)
    {
        $this->writeable = $writeable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReadable()
    {
        return $this->readable;
    }

    /**
     * @param mixed $readable
     *
     * @return self
     */
    public function setReadable($readable)
    {
        $this->readable = $readable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNullable()
    {
        return $this->nullable;
    }

    /**
     * @param mixed $nullable
     *
     * @return self
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubresource()
    {
        return $this->subresource;
    }

    /**
     * @param mixed $subresource
     *
     * @return self
     */
    public function setSubresource($subresource)
    {
        $this->subresource = $subresource;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     *
     * @return self
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     *
     * @return self
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTranslateable()
    {
        return $this->translateable;
    }

    /**
     * @param mixed $translateable
     *
     * @return self
     */
    public function setTranslateable($translateable)
    {
        $this->translateable = $translateable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param mixed $access
     *
     * @return self
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }
}
