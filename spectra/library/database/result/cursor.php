<?php

  class Spectra_Library_Database_Result_Cursor{

    private $results = null;
    private $statement = null;

    public function __get($name)
    {
      return $this->result[$name];
    }

    public function key()
    {
      static $index = 0;
      return $index++;
    }

    public function next()
    {
      return $this->result = $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function valid()
    {
      return ($this->result === false ? false : true);
    }

    public function rewind()
    {
      return null;
    }

    public function close()
    {
      $statement->closeCursor();
    }

    public function getResults()
    {
      return $this->results;
    }

    public function bindResults($statement)
    {
      $this->statement = $statement;
      $this->results = $statement->fetch(PDO::FETCH_ASSOC);
    }

  }
