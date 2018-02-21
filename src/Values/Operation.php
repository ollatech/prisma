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
    public $description;

    /**
     * @var array
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
     * @var string
     */
    public $resource;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var array | null
     */
    public $route;

    /**
     * @var string | null
     */
    public $template;


    /**
     * @var string | null
     */
    public $js;

    /**
     * @var string | null
     */
    public $css;




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
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     *
     * @return self
     */
    public function setTags(array $tags)
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
     * @return string | null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string | null $template
     *
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * @param string | null $js
     *
     * @return self
     */
    public function setJs($js)
    {
        $this->js = $js;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param string | null $css
     *
     * @return self
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }
}
