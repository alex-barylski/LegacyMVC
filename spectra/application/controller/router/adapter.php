<?php

  class Spectra_Application_Controller_Router_Adapter{

    private $provider = null;

    public function __construct($params, $request, $provider)
    {
      $provider->processRoute($params, $request);
      $this->provider = $provider;
    }

    public function getProvider()
    {
      return $this->provider;
    }

  }