<?php

  class Spectra_Library_Database_Result_Associative{

  	private $results = null;

  	private $count = 0;

    public function getCount()
    {
      return $this->count;
    }

    public function setCount($count)
    {
      $this->count = (int)$count;
      return $this;
    }

    public function getResults($index = -1, $field = null)
    {
    	if($index == -1){
    		return $this->results;
    	}

      if(is_null($field)){
        return $this->results[$index];
    	}

      return $this->results[$index][$field];
    }

    public function bindResults($statement)
    {
      $this->results = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $this;
    }

  }
