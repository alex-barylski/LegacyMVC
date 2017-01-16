<?php

  class Spectra_Library_Database_Gateway_Provider_MySql extends Spectra_Library_Database_Gateway_Provider_Abstract{

    public function createRecord($table, $params)
    {
    	$keys1 = implode(', ', array_keys($params));
    	$keys2 = implode(', ', array_map(create_function('$e', 'return ":".$e;'), array_keys($params)));

      $query = "INSERT INTO $table ($keys1) VALUES ($keys2)";

      $this->getStatement()->executePrepared($query, $params);

      return $this->getStatement()->getLastInsertId();
    }

    public function returnRecord($table, $params, $primary = array())
    {
      $field = (is_null($params) ? '*' : implode(', ', array_values((array)$params)));

      $where = $this->simpleWhereClause($primary);
      $query = "SELECT $field FROM $table $where";

      $result = new Spectra_Library_Database_Result_Associative();
    	$this->getStatement()->executePrepared($query, $primary, $result);

    	$result->setCount(count($result->getResults()));

    	return $result;
    }

    public function updateRecord($table, $params, $primary = array())
    {
    	$field = '';
    	$array = array_keys($params);
      foreach($array as $key){
        $field = "$field $key = :$key, ";
      }
      $field = trim($field, ', ');

      $where = $this->simpleWhereClause($primary);

      $query = "UPDATE $table SET $field $where";

      return $this->getStatement()->executePrepared($query, array_merge($params, $primary));
    }

    public function deleteRecord($table, $primary = array())
    {
    	$where = $this->simpleWhereClause($primary);

    	$query = "DELETE FROM $table $where";

      return $this->getStatement()->executePrepared($query, $primary);
    }

    public function selectRecords($table, $where = array(), $limit = array(), $order = array(), $group = array(), $having = array())
    {
    	$params = array();

      $where = $this->completeWhereClause($where, $params);

      $limit = $this->completeLimitClause($limit);

      $order = $this->completeOrderClause($order);
      $group = $this->completeGroupClause($group);
      $having = $this->completeHavingClause($having);

      $query = "SELECT * FROM $table $where $group $having $order $limit";
      $result = new Spectra_Library_Database_Result_Associative();
      $this->getStatement()->executePrepared($query, $params, $result);

      $query = "SELECT COUNT(*) AS spectra_cnt FROM $table $where $group $having $order";
      $counter = new Spectra_Library_Database_Result_Associative();
      $this->getStatement()->executePrepared($query, $params, $counter);

      // NOTE: Set the counter on the resultset object
      $result->setCount($counter->getResults(0, 'spectra_cnt'));

      return $result;
    }

    //
    // SQL builder operations
    //

    protected function simpleWhereClause($primary, $connective = 'AND')
    {
      $where = '';

      // NOTE: No WHERE clause is constructed if $primary key(s) are NULL
      if(!empty($primary)){
	      $array = array_keys($primary);
	      foreach($array as $key){
	        $where = "$where $key = :$key $connective";
	      }
	      $where = rtrim($where, $connective);
	      $where = "WHERE $where";
      }

      return $where;
    }

    protected function completeWhereClause($expressions, &$params)
    {
      if(empty($expressions)){
        return '';
      }

      $clause = $this->buildWhereClause($expressions, $params);
      $clause = "WHERE $clause";

      return $clause;
    }

    protected function completeLimitClause($limit)
    {
    	if(empty($limit) || count($limit) != 2){
    		return '';
    	}

      list($offset, $length) = $limit;

      $output = "LIMIT $offset";
      return $length == -1 ? "$output, 18446744073709551615" : "$output, $length";
    }

    protected function completeOrderClause($order)
    {
      if(empty($order)){
        return '';
      }

      $output = '';
      $order = array_reverse($order);
      foreach($order as $index => $item){
      	$field = $item[0];
      	$direction = isset($item[1]) ? $item[1] : 'ASC';

        $output = "$field $direction, $output";
      }
      $output = trim($output, ', ');

      return "ORDER BY $output";
    }

    protected function completeGroupClause($group)
    {
      if(empty($group)){
        return '';
      }

      $group = implode(', ', $group);

    	return "GROUP BY $group";
    }

    protected function completeHavingClause($order)
    {
      return '';
    }

    private function buildWhereClause(&$nodes, &$params)
    {
    	// NOTES: Operator associativity (http://en.wikipedia.org/wiki/Operator_associativity)
      static $depth = 0;
    	static $query = '';

      static $flag_connective = false;

      foreach($nodes as &$node){
        if(is_array($node)){
        	$depth++;
          $this->buildWhereClause($node, $params);
          $depth--;
        }

        if($this->isNodeConnective($node)){
          $flag_connective = $node;
        }
        else{

          if($this->isNodeComparative($node)){

            $operator = $nodes[0];
            $field = $nodes[1];
            $value = $nodes[2];

            // NOTE: IN() requires special handling from other comparison operators
            if($operator == Spectra_Library_Database_Gateway_Provider_Abstract::OP_IN){
              foreach($value as $item){
            	  $named[] = ':'.$this->nextNamedParameter($field, $item, $params);
              }
              $named_list = implode(', ', $named);

              if($flag_connective !== false){
                $temp = "$field IN ($named_list)";
                $query = "$query $temp $flag_connective`";
                $flag_connective = false;
              }
              else{
                $query = "$query $field IN ($named_list)";
              }
            }
            else{ // NOTE: Handle other comparison operators (= - < - > - !=)

            	// NOTE: If field value is an object than an expression is built in SQL not PHP using bound variables
              if($value instanceOf stdClass){
              	$named = $value->scalar;
              }
              else{
              	$named = ':'.$this->nextNamedParameter($field, $value, $params);
              }

	            if($flag_connective !== false){
	              $temp = "$field $operator $named";
	              $query = "$query $temp $flag_connective";
	              $flag_connective = false;
	            }
	            else{
	              $query = "$query $field $operator $named";
	            }
            }

            break;
          }
        }
      }

      // NOTE: Check the recurions depth and if ZERO it's safe to assume we are
      //       returning the value to the client caller (not internally) so we clear static

      $temp = $query;
      if($depth == 0){
        $query = '';
      }
      
      return $temp;
    }

    private function isNodeParenthesis($node)
    {
      return ($node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_PAREN);
    }

    private function isNodeConnective($node)
    {
      $result =
      (
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_OR
        ||
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_AND
      );

      return $result;
    }

    private function isNodeComparative($node)
    {
      $result =
      (
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_IN
        ||
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_EQ
        ||
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_LT
        ||
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_GT
        ||
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_LTE
        ||
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_GTE
        ||              
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_BOR
        ||              
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_BAND
        ||              
        $node === Spectra_Library_Database_Gateway_Provider_Abstract::OP_LIKE
      );

      return $result;
    }

    private function nextNamedParameter($field, $value, &$params)
    {
    	static $count = array();

    	$named = $field.'_'.intval($count[$field]++);
    	$params[$named] = $value;

    	return $named;
    }

  }