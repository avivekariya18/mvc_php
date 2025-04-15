<?php
class Core_Model_Resource_Collection_Abstract
{
   protected $_resource;
   protected $_model;
   protected $_select;
   public function setResource($resource)
   {
      $this->_resource = $resource;
      //print_r($this);
      return $this;
   }

   public function setModel($model)
   {
      $this->_model = $model;
      //print_r($this);
      return $this;
   }

   public function select($columns = ["*"])
   {

      $this->_select["FROM"] = ["main_table" => $this->_resource->getTableName()];
      // $this->_select["COLUMNS"] = is_array($columns) ? $columns : [$columns];
      $this->_select["COLUMNS"] = [];
      $columns = is_array($columns) ? $columns : [$columns];
      foreach ($columns as $alias=> $column) {
         if(is_integer($alias)){
            $this->_select["COLUMNS"][] = "main_table." . $column;
            
         }else{
            $this->_select["COLUMNS"][] = $column . " AS " . $alias;

         }
      }
      //print_r($this);
      return $this;
   }

   public function getData()
   {
      //  $query = sprintf("SELECT %s FROM %s", implode(",", $this->_select["COLUMNS"]), $this->_select["FROM"]);
      //  print_r($this->_resource);
      //echo "<pre>";
      $data = $this->_resource->getAdapter()->fetchAll($this->prepareQuery());
      //print_r($data);

      // print_r($data);
      foreach ($data as &$_data) {

         $_model = new $this->_model;
         //print_r($_model);
         $_data =  $_model->setData($_data);
         //  print_r($_data);


      }

      return $data;
   }


   public function addFieldToFilter($field, $condition)
   {
      if (!is_array($condition) && $condition != '') {
         $condition = ['eq' => $condition];
      }elseif(!is_array($condition) && $condition == ''){
         $condition = ['NULL' => $condition];
      }
      $this->_select["WHERE"][$field][] = $condition;
      // print_r($this);
      return $this;
   }

   public function prepareQuery()
   {
      $query = sprintf("SELECT %s FROM `%s` AS %s", implode(",", $this->_select["COLUMNS"]), array_values($this->_select["FROM"])[0], array_keys($this->_select["FROM"])[0]);
      // print($query);
      if (isset($this->_select['INNER_JOIN'])) {
         $innerJoinSql = "";
         foreach ($this->_select['INNER_JOIN'] as $innerJoin) {
            $innerJoinSql .= sprintf("INNER JOIN %s ON %s", $innerJoin['tableName'], $innerJoin['condition']);
         }
         $query = $query . " " . $innerJoinSql;
         // echo $query."<br>";
      }

      if (isset($this->_select['LEFT_JOIN'])) {
         $joinSql = "";
         foreach ($this->_select['LEFT_JOIN'] as $joinLeft) {
            //print_r($joinLeft);
            $joinSql .= sprintf("LEFT JOIN %s AS %s ON %s", array_values($joinLeft['tableName'])[0], array_keys($joinLeft['tableName'])[0], $joinLeft['condition']);
         }
         $query = $query . " " . $joinSql;
         // echo $query."<br>";
      }

      if (isset($this->_select['RIGHT_JOIN'])) {
         $rightJoinSql = "";
         foreach ($this->_select['RIGHT_JOIN'] as $rightJoin) {
            //print_r($joinLeft);
            $rightJoinSql .= sprintf("RIGHT JOIN %s ON %s", $rightJoin['tableName'], $rightJoin['condition']);
         }
         $query = $query . " " . $rightJoinSql;
         //echo $query."<br>";
      }

      if (isset($this->_select['JOIN'])) {
         $joinSql = "";
         foreach ($this->_select['JOIN'] as $Join) {
            //print_r($joinLeft);
            $joinSql .= sprintf("JOIN %s AS %s ON %s", array_values($Join['tableName'])[0], array_keys($Join['tableName'])[0], $Join['condition']);
         }
         $query = $query . " " . $joinSql;
         //echo $query."<br>";
      }

      if (isset($this->_select['FULL_JOIN'])) {
         $JoinSql = "";
         foreach ($this->_select['FULL_JOIN'] as $fullJoin) {
            //print_r($joinLeft);
            $JoinSql .= sprintf("FULL JOIN %s ON %s", $fullJoin['tableName'], $fullJoin['condition']);
         }
         $query = $query . " " . $JoinSql;
         // echo $query."<br>";
      }

      if (isset($this->_select['CROSS_JOIN'])) {
         $JoinSql = "";
         foreach ($this->_select['CROSS_JOIN'] as $crossJoin) {
            //print_r($joinLeft);
            $JoinSql .= sprintf("CROSS JOIN %s ON %s", $crossJoin['tableName'], $crossJoin['condition']);
         }
         $query = $query . " " . $JoinSql;
         //echo $query."<br>";
      }

      if (isset($this->_select['RIGHT_JOIN'])) {
         $rightJoinSql = "";
         foreach ($this->_select['RIGHT_JOIN'] as $rightJoin) {
            //print_r($joinLeft);
            $rightJoinSql .= sprintf("RIGHT JOIN %s ON %s", $rightJoin['tableName'], $rightJoin['condition']);
         }
         $query = $query . " " . $rightJoinSql;
         // echo $query."<br>";
      }

      if (isset($this->_select['WHERE'])) {
         $wheresql = "";
         $count = count($this->_select['WHERE']);
         $condition = [];
         //print($count);
         foreach ($this->_select['WHERE'] as $field => $value) {
            foreach ($value as $_value) {
               $condition[] = $this->where($field, $_value);
               // print_r($condition);
            }
         }
         $wheresql .= "WHERE " . implode(" AND ", $condition);
         $query = $query . " " . $wheresql;
         // echo $query."<br>";
      }

      if (isset($this->_select['GROUP_BY'])) {
         $groupSql = "";
         $groupSql .= sprintf("GROUP BY %s", implode(",", $this->_select['GROUP_BY']));
         $query = $query . " " . $groupSql;
         //echo $query."<br>";
         if (isset($this->_select['HAVING'])) {
            $havingSql = "";
            $count = count($this->_select["HAVING"]);
            $condition = [];
            foreach ($this->_select['HAVING'] as $field => $value) {
               foreach ($value as $_value) {
                  $condition[] = $this->where($field, $_value);
                  //print_r($condition);
               }
            }
            $havingSql .= "HAVING " . implode("AND", $condition);
            $query = $query . " " . $havingSql;
            // echo $query."<br>";
         }
      }



      // if(isset($this->_select["HAVING_AGGREGATE"])){
      //    $havingAggSql = "";
      //    $count = count($this->_select["HAVING_AGGREGATE"]);
      //    $condition = [] ;
      //    foreach($this->_select['HAVING_AGGREGATE'] as $field => $value)
      //    {
      //       foreach($value as $_value){
      //          print_r($_value);
      //          $condition[] = "{$field} ".key($_value)." ".current($_value);

      //       }
      //    }
      //    $havingAggSql .= (isset($havingSql) ? " AND " : "HAVING ") . implode(" AND ", $condition);
      //    $query = $query." ".$havingAggSql;
      //    echo $query."<br>";
      // }

      if (isset($this->_select["ORDER_BY"])) {
         $orderSql = "";


         // print_r($this->_select["ORDER_BY"]); 

         $orderSql .= sprintf("ORDER BY %s", implode(",", $this->_select['ORDER_BY']));
         $query = $query . " " . $orderSql;

         //   echo $query . "<br>";
      }

      if (isset($this->_select["LIMIT"])) {
         //print_r($this->_select["LIMIT"]); 
         // print_r($this);
         $limit = " ";
         $limit = sprintf("LIMIT %s OFFSET %s", $this->_select["LIMIT"]["limit"], $this->_select["LIMIT"]["offset"]);
         $query = $query . " " . $limit;
         // echo  $query . "<br>";
      }
      // echo $query."<br>";
      return $query;
   }

   public function where($field, $value)
   {
      if (is_array($value)) {

         foreach ($value as $operator => $_value) {
            switch (strtoupper($operator)) {
               case 'IN':
               case 'NOT IN':

                  $_value = (is_array($_value)) ? $_value : [$_value];

                  foreach ($_value as $key => $val) {

                     $inarryvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";
                  }
                  $_value = implode(',', $inarryvalues);
                  $where  = " {$field} {$operator} ({$_value}) ";
                  break;

               case 'BETWEEN':
               case 'NOT BETWEEN':
                  foreach ($value as $key => $val) {
                     if (is_array($val)) {
                        foreach ($val as $limits) {
                           $betweenvalues[] = (is_string($limits)) ? "'{$limits}'" : "{$limits}";
                        }
                     } else {
                        $betweenvalues[] = (is_string($val)) ? "'{$val}'" : "{$val}";
                     }
                  }
                  $betweenvaluestring = implode(' AND ', $betweenvalues);
                  $where  =   " {$field} {$operator} {$betweenvaluestring}";
                  break;

               case 'EQ':
                  $where = "{$field} = '{$_value}'";
                  break;
               case 'NEQ':
                  $where = "{$field} != '{$_value}'";
                  break;
               case 'GTEQ':
                  $where = "{$field} >= '{$_value}'";
                  break;
               case 'LTEQ':
                  $where = "{$field} <= '{$_value}'";
                  break;
               case 'NOTNULL':
                  $where = "{$field} IS NOT NULL";
                  break;

               case 'NULL':
                  $where = "{$field} IS NULL";
                  break;

               default:
                  $where = " {$field} {$operator} '{$_value}' ";
                  break;
            }
         }
      }
      //print($where);
      return $where;
   }

   public function innerJoin($tablename, $condition, $columns)
   {
      $this->_select['INNR_JOIN'][] = ['tableName' => $tablename, 'condition' => $condition, 'columns' => $columns];
      //print_r( $this->_select['JOIN_LEFT']);
      foreach ($columns as $alias => $columnName) {
         $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s ", $tablename, $columnName, $alias);
      }
      return $this;
   }
   public function leftJoin($tablename, $condition, $columns)
   {
      $this->_select['LEFT_JOIN'][] = ['tableName' => $tablename, 'condition' => $condition, 'columns' => $columns];
      //print_r( $this->_select['JOIN_LEFT']);
      foreach ($columns as $alias => $columnName) {
         $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s ", array_keys($tablename)[0], $columnName, $alias);
      }
      return $this;
   }
   public function join($tablename, $condition, $columns)
   {
      $this->_select['JOIN'][] = ['tableName' => $tablename, 'condition' => $condition, 'columns' => $columns];
      //print_r( $this->_select['JOIN_LEFT']);
      foreach ($columns as $alias => $columnName) {
         $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s ", array_keys($tablename)[0], $columnName, $alias);
      }
      return $this;
   }


   public function rightJoin($tablename, $condition, $columns)
   {
      $this->_select['RIGHT_JOIN'][] = ['tableName' => $tablename, 'condition' => $condition, 'columns' => $columns];
      //print_r( $this->_select['JOIN_LEFT']);
      foreach ($columns as $alias => $columnName) {
         $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s ", $tablename, $columnName, $alias);
      }
      return $this;
   }
   public function fullJoin($tablename, $condition, $columns)
   {
      $this->_select['FULL_JOIN'][] = ['tableName' => $tablename, 'condition' => $condition, 'columns' => $columns];
      //print_r( $this->_select['JOIN_LEFT']);
      foreach ($columns as $alias => $columnName) {
         $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s ", $tablename, $columnName, $alias);
      }
      return $this;
   }

   public function crossJoin($tablename, $condition, $columns)
   {
      $this->_select['CROSS_JOIN'][] = ['tableName' => $tablename, 'condition' => $condition, 'columns' => $columns];
      //print_r( $this->_select['JOIN_LEFT']);
      foreach ($columns as $alias => $columnName) {
         $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s ", $tablename, $columnName, $alias);
      }
      return $this;
   }
   public function groupBy($columns)
   {
      $this->_select['GROUP_BY'] = $columns;
      return $this;
   }

   public function having($field, $condition)
   {
      if (!is_array($condition)) {
         $condition = ['eq' => $condition];
      }
      $this->_select["HAVING"][$field][] = $condition;
      //print_r($this);
      return $this;
   }

   public function orderBy($columns)
   {
      $this->_select["ORDER_BY"] = $columns;
      // print_r($this);
      return $this;
   }

   public function limit($limit, $offset = 0)
   {
      $this->_select["LIMIT"] = ["limit" => $limit, 'offset' => $offset];
      return $this;
   }
   private function getTableAlias($table)
   {
      return array_keys($table)[0];
   }
   private function getTableName($table)
   {
      return array_values($table)[0];
   }
   public function getfirstItem(){
      $data = $this->getData();
      if(isset($data[0])){
         return $data[0];
      }
      return $this->_model;
   }
}
