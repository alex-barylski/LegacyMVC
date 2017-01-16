<?php

  class Spectra_Library_Database_Gateway_Adapter{

  	private $provider = null;

    public function __construct($provider)
    {
      $this->provider = $provider;
    }

    public function getProvider()
    {
      return $this->provider;
    }

  }