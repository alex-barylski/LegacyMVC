<?php

  class Spectra_Application_Controller_Router_Provider_Default extends Spectra_Application_Controller_Router_Provider_Abstract{

    public function __construct($controller_name, $controller_action)
    {
      $this->setControllerName($controller_name);
      $this->setControllerAction($controller_action);
    }

    public function processRoute($params, $request)
    {
      // NOTE: Processing of request params is not required as controller:action are explicitly provided by client
    }

    public function assembleRoute($name, $params)
    {
      // NOTE: Processing of request params is not required as controller:action are explicitly provided by client
    }

  }