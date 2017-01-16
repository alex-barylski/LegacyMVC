<?php

  class Spectra_Application_Controller_Front{

    private $filters = array();

    private $request = null;
    private $response = null;

    private $dispatchLog = array();

    private function __construct(){ /* Singleton */ }

    public static function getInstance()
    {
      static $instance = null;

      if($instance === null){
        $instance = new self();

        $instance->filters['PRE'] = array();
        $instance->filters['POST'] = array();
      }

      return $instance;
    }

    public function getDispatchLog()
    {
      return $this->dispatchLog;
    }

    public function getPluginFilters($type)
    {
      return $this->filters[$type];
    }

    public function getRequestObject()
    {
      return $this->request;
    }

    public function getResponseObject()
    {
      return $this->response;
    }

    public function setRequestObject(Spectra_Application_Request $request)
    {
      $this->request = $request;
      return $this;
    }

    public function setResponseObject(Spectra_Application_Response $response)
    {
      $this->response = $response;
      return $this;
    }

    // NOTE: Everything below this belong in dispatcher standard provider
    public function addPrePluginFilter(Spectra_Application_Controller_Command $controller_object)
    {
      $this->filters['PRE'][] = $controller_object;
      return $this;
    }

    public function addPostPluginFilter(Spectra_Application_Controller_Command $controller_object)
    {
      $this->filters['POST'][] = $controller_object;
      return $this;
    }

    public function dispatchAction(Spectra_Application_Controller_Command $controller_object, $controller_action)
    {
      $class_method = get_class($controller_object).'::'.$controller_action;
      $this->dispatchLog[][$class_method] = time();

      $this->invokePluginFilters('PRE', $controller_action)
           ->invokeAction($controller_object, 'preDispatch', $controller_action)
           ->invokeAction($controller_object, $controller_action)
           ->invokeAction($controller_object, 'postDispatch', $controller_action)
           ->invokePluginFilters('POST', $controller_action);

      return $this;
    }

    protected function invokeAction($controller_object, $controller_action, $controller_params = null)
    {
      $controller_object->{$controller_action}($controller_params);
      return $this;
    }

    protected function invokePluginFilters($type, $action)
    {
      foreach($this->filters[$type] as $controller_object){
        $this->invokeAction($controller_object, 'execute', $action);
      }

      return $this;
    }

  }