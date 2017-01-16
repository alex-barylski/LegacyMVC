<?php

  class Spectra_Helper_Model_Proxy{

    private $object = null;

    public function __construct($object)
    {
      $this->object = $object;
    }

    public function invokeMethod($method, $params = array())
    {
      $reflector = new ReflectionMethod(get_class($this->object), $method);

      $mapped = array();
      foreach($reflector->getParameters() as $param){
        $name = $param->getName();

        $value = isset($params[$name]) ? $params[$name] : $param->getDefaultValue();

        $mapped[$name] = $value;
      }


      // NOTE: Invoke the pre and post method invocation intercepts to allow greater SoC
      //$results = $this->object->postInvoke
      //(
      //  $method,
      //  $reflector->invokeArgs
      //  (
      //    $this->object,
      //    $this->object->preInvoke($method, $mapped)
      //  )
      //);

      $results = $reflector->invokeArgs($this->object, $mapped);

      return $results;
    }

  }

