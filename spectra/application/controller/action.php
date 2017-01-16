<?php

  abstract class Spectra_Application_Controller_Action extends Spectra_Application_Controller_Command{

    private $params = null;

    public function preDispatch($action){ /* No default implementation -- should be overridden by client developer */ }
    public function postDispatch($action){ /* No default implementation -- should be overridden by client developer */ }

    protected function getParams()
    {
      return $this->params;
    }

    protected function forwardAction($controller_object, $controller_action, $controller_params = null)
    {
      if($controller_params !== null){
        $this->params = $controller_params;
      }

      return $this->getFrontObject()->dispatchAction($controller_object, $controller_action);
    }

  }