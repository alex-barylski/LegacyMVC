<?php

  class Spectra_Library_Database_Facade{

    private $connection = null;
    private $statement = null;
    private $gateway = null;

    private $table_prefix = '';

    public function __construct($db_type, $db_name, $db_user, $db_pass, $db_host, $db_port)
    {
      $this->initializeDb($db_type, $db_name, $db_user, $db_pass, $db_host, $db_port);
    }

    public function getConnection()
    {
      return $this->connection;
    }

    public function getStatement()
    {
      return $this->statement;
    }

    public function getGateway()
    {
      return $this->gateway->getProvider();
    }

    public function setTablePrefix($table_prefix)
    {
      $this->table_prefix = $table_prefix;
      return $this;
    }

    protected function initializeDb($db_type, $db_name, $db_user, $db_pass, $db_host, $db_port)
    {
      $this->connection = new Spectra_Library_Database_Connection_Adapter(
        new Spectra_Library_Database_Connection_Provider_MySql($db_name, $db_user, $db_pass, $db_host, $db_port)
      );
      $this->statement = new Spectra_Library_Database_Decorator($this->connection, $this->table_prefix);

      $this->gateway = new Spectra_Library_Database_Gateway_Adapter(new Spectra_Library_Database_Gateway_Provider_MySql($this->statement));
    }

  }