<?php

  abstract class Spectra_Application_Controller_Router_Provider_Abstract{

    private $routes = array();

    private $controller_name = '';
    private $controller_action = '';

    abstract public function processRoute($params, $request);
    abstract public function assembleRoute($name, $params);

    public function __construct($routes)
    {
      $this->routes = $routes;
    }

    public function getRoutes()
    {
      return $this->routes;
    }

    public function getControllerName()
    {
      return $this->controller_name;
    }

    public function setControllerName($controller_name)
    {
      $this->controller_name = $controller_name;
      return $this;
    }

    public function getControllerAction()
    {
      return $this->controller_action;
    }

    public function setControllerAction($controller_action)
    {
      $this->controller_action = $controller_action;
      return $this;
    }

  }