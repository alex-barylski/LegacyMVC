<?php

  abstract class Spectra_Library_Database_Gateway_Provider_Abstract{

    const OP_IN = 'IN';

  	const OP_EQ = '=';

  	const OP_LT = '<';
  	const OP_GT = '>';

  	const OP_LTE = '<=';
  	const OP_GTE = '>=';

  	const OP_OR = 'OR';
  	const OP_AND = 'AND';

    const OP_BOR = '|';
    const OP_BAND = '&';
    
  	const OP_LIKE = 'LIKE';

  	private $statement = null;

  	public function __construct($statement)
  	{
  		$this->statement = $statement;
  	}

  	public function getStatement()
  	{
  	 return $this->statement;
  	}

    abstract public function createRecord($table, $params);

    abstract public function returnRecord($table, $params, $primary = array());

    abstract public function updateRecord($table, $params, $primary = array());

    abstract public function deleteRecord($table, $primary = array());

    abstract public function selectRecords($table, $where = array(), $limit = array(), $order = array(), $group = array(), $having = array());

  }

  //
  // SQL operator helper functions
  //

  function S_IN($op1, $values)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_IN, $op1, $values);
  }

  function S_EQ($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_EQ, $op1, $op2);
  }

  function S_LT($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_LT, $op1, $op2);
  }

  function S_GT($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_GT, $op1, $op2);
  }

  function S_LTE($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_LTE, $op1, $op2);
  }

  function S_GTE($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_GTE, $op1, $op2);
  }

  function S_OR($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_OR, $op1, $op2);
  }

  function S_AND($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_AND, $op1, $op2);
  }

  function S_BOR($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_BOR, $op1, $op2);
  }

  function S_BAND($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_BAND, $op1, $op2);
  }
  
  function S_LIKE($op1, $op2)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_LIKE, $op1, $op2);
  }

  function S_REGEX($op1, $op2)
  {

  }

  //
  // Supporintg clause helper functions - extra validation and error checking?
  // These functions also make it more obvious what parameters to SELECT are doing
  //

  function S_VERIFY($value, $compare = null)
  {
    return ($value === $compare);
  }

  function S_LIMIT($offset, $length)
  {
    return array($offset, $length);
  }

  function S_EXPR($field)
  {
    return (object)$field; // NOTE: Accessed using $object->scalar
  }

  function S_PAREN($result)
  {
    return array(Spectra_Library_Database_Gateway_Provider_Abstract::OP_PAREN, $result);
  }