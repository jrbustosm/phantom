<?php

/**
 * ConnectorSQLite
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/ConectorSQLite.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase ConnectorSQLite
 * 
 * Adapter to manage a connection to a SQLite database
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @version $Id$
 * @package core
 * @since 0.1
 * @see ConnectorDB
 */
class ConnectorSQLite extends ConnectorDB{

  /**
   * open
   *
   * Stores within the handler attribute a valid 
   * connection resource manager with SQLite database
   *
   * @override
   */
  public function open(){
    $this->handler=new SQLite3($GLOBALS['_DBNAME']);
  }

  /**
   * close
   *
   * Finish the connection to the database handler SQLite
   *
   * @override
   */
  public function close(){
    $this->handler->close();
  }

  /**
   * run
   *
   * Executes an SQL sentence in the Database manager
   *
   * @param string $sql SQL sentence to execute
   * @return mixed The result of executing this sentence
   * @override
   */
  public function run($sql){
    return $this->handler->exec($sql);
  }

  /**
   * search
   *
   *Find a group of records in a table according to certain criteria
   *
   * @todo generators can be improved php 5.5
   * @param string $table Name of the table where the data search
   * @param string $where Search criteria of the select sentence in SQL format
   * @param string $class Name of the class that generates output instances,
   *                      if equal to empty it returns an array of arrays
   * @return array  Un arreglo de objetos de tipo class o arrays, 
   *                como resultado de buscar los registros en la tabla y criterios de indicados
   * @override
   */
  public function search($table, $where="", $class=""){
    $sql = "SELECT * FROM $table";
    if($where) $sql .= " WHERE $where";
    $records = $this->handler->query($sql);
    return $this->toArray($records, $class);
  }
  
  /**
   * delete
   *
   * Delete a group of records in a table according to certain criteria
   *
   * @param string $table Name of the table where you erase data
   * @param string $where Search criteria of the select sentence in SQL format
   * @override
   */
  public function delete($table, $where){
    $sql = "DELETE FROM $table WHERE $where";
    echo $sql;
    $this->handler->query($sql);
  }

  /**
   * desc
   *
   * Find the description of the columns in a table in a SQLite database
   *
   * @param string $table name of table to describe
   * @return array An associative array of objects of type Fields
   * @override
   */
  public function desc($table){
    $sql = "PRAGMA table_info($table)";
    $records = $this->handler->query($sql);
    $v = $this->toArray($records);
    //Array to map the names of the keys required by the returned SQLite
    $map = array(
      "name"=>"name",
      "pk"=>"pk",
      "notNull"=>"notnull",
      "defaultValue"=>"dflt_value",
      "type"=>"type",
    );
    $field = array();
    foreach($v as $row){
      $field[$row[$map["name"]]] = new Field($row, $map);
    }
    return $field;
  }
  
  /**
   * toArray
   *
   * Converts a search over an array
   *
   * @param resource $rs Search check to the database
   * @param string $class Name of the class that generates output instances,
   *                      if equal to empty it returns an array of arrays
   * @return array Array of objects of class type
   */
  private function toArray($rs, $class=""){
    $results = array();
    while ($reg = $rs->fetchArray()) {
      if($class) array_push($results, new $class($reg));
      else array_push($results, $reg);
    }
    return $results;
  }

}
