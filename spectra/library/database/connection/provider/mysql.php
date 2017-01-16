<?php

  class Spectra_Library_Database_Connection_Provider_MySql extends Spectra_Library_Database_Connection_Provider_Abstract{

    const DEFAULT_PORT = 3306;
    const DEFAULT_HOST = 'localhost';

    public function __construct($db_name, $db_user = '', $db_pass = '', $db_host = self::DEFAULT_HOST, $db_port = self::DEFAULT_PORT)
    {
      parent::__construct($db_name, $db_user, $db_pass, $db_host, $db_port);

      // DOCS: http://ca.php.net/manual/en/ref.pdo-mysql.connection.php
      $this->setType('mysql')->setDsn("mysql:dbname=$db_name;host=$db_host");
    }

  }