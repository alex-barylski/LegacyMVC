<?php

  abstract class Spectra_Library_Database_Connection_Provider_Abstract{

    private $dsn = '';

    private $type = '';

    private $name = '';
    private $user = '';
    private $pass = '';
    private $host = '';
    private $port = 0;

    public function getDsn(){ return $this->dsn; }
    public function setDsn($dsn)
    {
      $this->dsn = $dsn;
      return $this;
    }

    public function getType(){ return $this->type; }
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

    public function getName(){ return $this->name; }
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    public function getUser(){ return $this->user; }
    public function setUser($user)
    {
      $this->user = $user;
      return $this;
    }

    public function getPass(){ return $this->pass; }
    public function setPass($pass)
    {
      $this->pass = $pass;
      return $this;
    }

    public function getHost(){ return $this->host; }
    public function setHost($host)
    {
      $this->host = $host;
      return $this;
    }

    public function getPort(){ return $this->port; }
    public function setPort($port)
    {
      $this->port = $port;
      return $this;
    }

    public function __construct($db_name, $db_user, $db_pass, $db_host, $db_port)
    {
      $this->setName($db_name);
      $this->setUser($db_user);
      $this->setPass($db_pass);
      $this->setHost($db_host);
      $this->setPort($db_port);
    }

  }
