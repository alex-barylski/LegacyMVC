<?php

  class Spectra_Library_Database_Decorator extends Spectra_Library_Database_Statement{

  	const TABLE_PREFIX_MARKER = 'STP_';

    private $table_prefix = '';

    public function __construct($connection, $table_prefix)
    {
      parent::__construct($connection);
      $this->table_prefix = $table_prefix;
    }

    public function executePrepared($query, $params = null, &$results = null)
    {
      $query = str_replace(self::TABLE_PREFIX_MARKER, $this->table_prefix, $query);
      parent::executePrepared($query, $params, $results);
    }

  }