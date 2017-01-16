<?php

  class Spectra_Application_Environment_Http_Response extends Spectra_Application_Response{

    const STATUS_REQUEST_SUCCESSFUL = 200;

    const STATUS_PERMANENT_REDIRECT = 301;
    const STATUS_TEMPORARY_REDIRECT = 307;

    const STATUS_NOT_MODIFIED = 304;

    const STATUS_BAD_REQUEST = 400;
    const STATUS_NOT_FOUND = 404;

    private $headers = array();

    public function getHeader($name)
    {
      return $this->headers[$name];
    }

    public function setHeader($name, $value)
    {
      $this->headers[$name] = $value;
      return $this;
    }

    public function setRawHeader($header)
    {
      header($header);
      return $this;
    }

    public function clearHeaders()
    {
      unset($this->headers);
      $this->headers = array();
      return $this;
    }

    public function doRedirect($absolute_uri, $status_code = self::STATUS_TEMPORARY_REDIRECT)
    {
      header("Status: $status_code");
      header("Location: $absolute_uri");
      exit;
    }

    public function sendResponse()
    {
      foreach($this->headers as $name => $value){
        header("$name: $value");
      }

      return $this->getContent();
    }

  }