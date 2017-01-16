<?php

  class Spectra_Application_Request{

    private $values = array();

    public function __construct($values)
    {
      $this->values = $values;
    }

    public function getValues()
    {
      return $this->values;
    }

    public function getValue($name, $default)
    {
      return array_key_exists($name, $this->values) ? $this->values[$name] : $default;
    }

    public function setValue($name, $value)
    {
      $this->values[$name] = $value;
      return $this;
    }

  }