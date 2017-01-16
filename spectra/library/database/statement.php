<?php

  class Spectra_Library_Database_Statement{

  	private static $query = array();

    private $connection = null;

    public function __construct($connection)
    {
      $this->connection = $connection;
    }

    public static function getQueryLog()
    {
      return self::$query;
    }

    public function getDataObject()
    {
      return $this->connection->getDataObject();
    }

    public function getLastInsertId()
    {
      return $this->getDataObject()->lastInsertId();
    }

    public function beginTransaction()
    {
      return $this->getDataObject()->beginTransaction();
    }

    public function commitTransaction()
    {
      return $this->getDataObject()->commit();
    }

    public function rollbackTransaction()
    {
      return $this->getDataObject()->rollback();
    }

    public function executeStandard($query, $params = array(), &$results = null)
    {
    	self::$query[] = array($params, $query);
    }

    public function executePrepared($query, $params = array(), &$results = null)
    {
      self::$query[] = array($params, $query);

    	$statement = $this->getDataObject()->prepare($query);
      $statement->execute($params);

      if(!is_null($results)){
        $results->bindResults($statement);
        return false; // NOTE: Indicate method was called to return $results as out-going
      }

      // NOTE: Return the number of affected rows for INSERT, UPDATE, DELETE
      return $statement->rowCount();
    }

  }
