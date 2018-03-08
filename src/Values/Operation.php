<?php

namespace Olla\Prisma\Values;

final class Operation
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array | null
     */
    public $methods = [];

    /**
     * @var string
     */
    public $controller;

    /**
     * @var array | null
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
    public $alias;
    /**
     * @var string
     */
    public $description;

    /**
     * @var array | null
     */
    public $tags;

    /**
     * @var array | null
     */
    public $parameters;

    /**
     * @var array | null
     */
    public $consumes;

    /**
     * @var array | null
     */
    public $produces;

    /**
     * @var array | null
     */
    public $responses;

    /**
     * @var array | null
     */
    public $permissions;

    /**
     * @var array | null
     */
    public $arguments;

    

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

     /**
     * @param array $data An array of key/value parameters
     *
     * @throws \BadMethodCallException
     */
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
                //throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".', $key, get_class($this)));
            }
            $this->$method($value);
        }
    }



    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path.'.{_format}';

        return $this;
    }

    /**
     * @return array | null
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array | null $methods
     *
     * @return self
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     *
     * @return self
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param array | null $route
     *
     * @return self
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     *
     * @return self
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return self
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array | null $tags
     *
     * @return self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array | null $parameters
     *
     * @return self
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getConsumes()
    {
        return $this->consumes;
    }

    /**
     * @param array | null $consumes
     *
     * @return self
     */
    public function setConsumes($consumes)
    {
        $this->consumes = $consumes;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getProduces()
    {
        return $this->produces;
    }

    /**
     * @param array | null $produces
     *
     * @return self
     */
    public function setProduces($produces)
    {
        $this->produces = $produces;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param array | null $responses
     *
     * @return self
     */
    public function setResponses($responses)
    {
        $this->responses = $responses;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param array | null $permissions
     *
     * @return self
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array | null $arguments
     *
     * @return self
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param array $assets
     *
     * @return self
     */
    public function setAssets(array $assets)
    {
        $this->assets = $assets;

        return $this;
    }

    /**
     * @return array
     */
    public function getReact()
    {
        return $this->react;
    }

    /**
     * @param array $react
     *
     * @return self
     */
    public function setReact(array $react)
    {
        $this->react = $react;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
