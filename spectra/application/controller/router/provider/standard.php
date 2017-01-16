<?php

  class Spectra_Application_Controller_Router_Provider_Standard extends Spectra_Application_Controller_Router_Provider_Abstract{

    private $active_route = '';
    private $default_route = '';

    public function __construct($routes, $default_route)
    {
      $this->default_route = $default_route;
      parent::__construct($routes);
    }

    public function processRoute($params, $request)
    {
      static $counter = 0;
      if($counter++ > 5){
        trigger_error('Failed to locate default route. Please make sure the route '.$params.' is located in the routing file.', E_USER_ERROR);
      }

      list($route1, $route2) = explode('/', $params);
      $this->active_route = $route1.'/'.$route2;

      $routes = $this->getRoutes();
      if(array_key_exists($this->active_route, $routes)){

        foreach($routes[$this->active_route] as $controller => $action){
          break; // NOTE: Were only interested in the first entry under this route/group -- if there are more the file is not formatted properly
        }

        $this->setControllerName($controller);
        $this->setControllerAction($action);

        return;
      }

      $this->processRoute($this->default_route);
    }

    public function assembleRoute($name, $params)
    {

    }

  }