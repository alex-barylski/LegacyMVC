<?php

  function stripslashes_deep($value)
  {
      $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
      return $value;
  }

  class Spectra_Application_Environment_Http_Request extends Spectra_Application_Request{

    public function __construct()
    {
      $request = $_REQUEST;

      if(get_magic_quotes_gpc()){
        $request = stripslashes_deep($request);
      }

      parent::__construct($request);
    }

    public function getMethod()
    {
      return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isXmlHttpRequest()
    {
      return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

  }