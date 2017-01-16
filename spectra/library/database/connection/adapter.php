<?php

  class Spectra_Library_Database_Connection_Adapter{

    private $provider = null;
    private $object = null;

    public function __construct($provider)
    {
      $this->provider = $provider;
    }

    public function getProvider()
    {
      return $this->provider;
    }

    public function getDataObject($attribs = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING))
    {
    	if(!is_null($this->object)){
        return $this->object;
    	}

      $this->object = new PDO
      (
        $this->getProvider()->getDsn(),
        $this->getProvider()->getUser(),
        $this->getProvider()->getPass(),
        $attribs
      );

      $this->getProvider()->setPass('');

      $type = $this->getProvider()->getType();
      $list = $this->object->getAvailableDrivers();

      if(!in_array($type, $list)){
        throw new Exception("PDO driver $type is not installed or available.");
      }

      return $this->object;
    }

  }