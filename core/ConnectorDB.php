<?

/**
 * ConnectorDB
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @link https://github.com/jrbustosm/phantom/blob/master/core/ConnectorDB.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Class ConnectorDB
 * 
 * Class created to describe the behavior of a database handler
 *
 * @property resource $handler Connecting to the database
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @version $Id$
 * @package core
 * @since 0.1
 * @see ConnectorSQLite
 */
abstract class ConnectorDB{

  protected $handler;

  /**
   * Construct
   *
   * Open the connection to the database handler
   *
   */
  function __construct(){
    $this->open();
  }

  /**
   * Destruct
   *
   * Close the connection to the database handler
   *
   */
  function __destruct(){
    $this->close();
  }

  /**
   * open
   *
   * Stores within the handler attribute valid connection 
   * resource with database manager
   *
   */
  abstract public function open();

  /**
   * close
   *
   * Finish the connection to the database handler
   *
   */
  abstract public function close();

  /**
   * run
   *
   * Executes a sentence SQL in the Database handler
   *
   * @param string $sql sentence SQL a ejecutar
   * @return mixed The result of executing this sentence
   */
  abstract public function run($sql);

  /**
   * searchAll
   *
   * Returns all records from a database
   *
   * @param string $table Name of table
   * @param string $class Name of the class of objects that will be returned
   *               if empty returns an array of arrays
   * @return array a Array with objects of class type or array with all table records requested
   */
  public function searchAll($table, $class=""){
    return $this->search($table, "", $class);
  }

  /**
   * searchXPK
   *
   * Find the record you have requested the Primary Keys
   * @todo if no record return NULL?
   * @param array $ids Array associative record ids to search
   * @param string $tabla name of table
   * @param string $class name of class of objects that will be
   * @return mixed a array, class type object or null if no record found
   */
  public function searchXPK(array $ids, $table, $class=""){
    $where = self::_Y($ids);
    $v = $this->search($table, $where, $class);
    return $v[0];
  }

  /**
   * deleteXPK
   *
   * Deletes a single record according to their primary keys
   *
   * @param array $ids Array ids associative record to be deleted
   * @param string $table name of table
   */  
  public function deleteXPK(array $ids, $table){
    $where = self::_Y($ids);
    $this->delete($table, $where);
  }

  /**
   * _Y
   *
   * SQL join different expressions stored in an associative array using the connector AND
   *
   * @todo can be improved
   * @param array $A array associative expressions unite
   */
  private static function _Y(array $A){
    array_walk($A, function(&$v, $k){
      $v = "$k='" . addslashes($v) . "'";
    });
    return implode(" AND ", $A);
  }

  /**
   * search
   *
   * Find a group of records in a table according to certain criteria
   *
   * @param string $table Name of the table where the data search
   * @param string $where Search criteria of the select sentence in format SQL
   * @param string $class Name of the class that generates output instances, 
   *                      if equal to empty it returns an array of arrays
   * @return Un arreglo de objetos de tipo class o arrays, como resultado de buscar
   *         los registros en la tabla y criterios de indicados
   */
  abstract public function search($table, $where, $class);

  /**
   * delete
   *
   * deletes a group of records in a table according to certain criteria
   *
   * @param string $table Name of the table where you erase data
   * @param string $where Search criteria of the delete statement in SQL format
   */
  abstract public function delete($table, $where);

  /**
   * desc
   *
   * Find the description of the columns in a table in a database
   *
   * @param string $table Name of the table to describe
   * @return array An associative array of objects of type Fields
   */
  abstract public function desc($table);

}
