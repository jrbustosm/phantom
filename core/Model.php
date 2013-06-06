<?php

/**
 * Model
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Modelo.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Class Model
 * 
 * Is a representation of a table in a database a model POO
 *
 * @property ConnectorDB $con handler of database
 * @property array $data log data 
 * @property array $mapFuncType array that maps the data types the function to evaluate data of this type
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package core
 * @since 0.1
 * @see ConnectorDB
 */
abstract class Model{

  private static $con; //handler of database
  private $data;      //Data stored in the registry

  private static $mapFuncType = array(
    "int" => "is_int",
    "integer" => "is_int",
    "text" => "is_string",
    "real" => "is_float",
  );

  /**
   * Construct
   *
   * __construct($id1, [$id2, ... , $idn])
   * __construct(array $data)
   *
   * @param string $ids Record identifiers
   * @param array $datos Associative array with log data
   */
  function __construct(){
    if(func_num_args()==1 && is_array(func_get_arg(0))){
      //First eliminate extra data that are not part of the model
      $data = array_intersect_key(func_get_arg(0), $this::$TABLEDATA['FIELD']);
      //Then verify that all required fields are
      $mandatory = $this::$TABLEDATA['MANDATORY'];
      if(array_intersect($mandatory,array_keys($data))!=$mandatory){
        throw new Exception('Missing data to build the model');
      }
      //We check if all data are entering the correct type
      if(!self::verifyArrayType($data)){
        throw new Exception('Invalid type argument');
      }
      $this->data = $data;
    }else if(func_num_args()>0){
      //Search data ids
      if(count($this::$TABLEDATA['PKS']) != func_num_args())
        throw new Exception('Number of erroneous arguments');
      $pks = array_combine($this::$TABLEDATA['PKS'], func_get_args());
      //check IDs types
      if(!self::verifyArrayType($pks)){
        throw new Exception('Invalid type argument');
      }
      $this->data = self::$con->searchXPK($pks, $this::$TABLEDATA['TABLENAME']);
      $this->data = array_intersect_key($this->data, $this::$TABLEDATA['FIELD']);
    }else{
      throw new Exception('Arguments are needed to create a model');
    }
  }
  
  /**
   * Method to check model properties
   *
   * @param string $porperty Property to consult
   * @return mixed Value of the requested property, if the property exists but is not defined returns NULL
   */
  public function __get($property){
    if(!in_array($property, array_keys($this::$TABLEDATA['FIELD'])))
      throw new Exception('Property nonexistent');
    if(isset($this->data[$property])) return $this->data[$property];
    return NULL;
  }

  /**
   * delete
   *
   * Clears the database
   *
   * @todo If the record does not yet exist should not do anything
   */
  public function delete(){
    $pks = array_intersect_key($this->data, array_combine($this::$TABLEDATA['PKS'],$this::$TABLEDATA['PKS']));
    self::$con->deleteXPK($pks, $this::$TABLEDATA['TABLENAME']);
  }

  /**
   * Method that initializes the class attributes
   */
  public static function static_init(){
    //Selected connector is selected in the configuration
    $conclass = "Connector" . $GLOBALS['_DBENGINE'];
    self::$con = new $conclass();
  }
  
  /**
   * Method that initializes the description of the schema of the table
   */
  public static function loadDesc(){
    $class = get_called_class();
    $class::$TABLEDATA['FIELD'] = self::$con->desc(static::$TABLEDATA['TABLENAME']);
    $class::$TABLEDATA['PKS'] = array_keys(
      array_filter($class::$TABLEDATA['FIELD'], function($c){
        return $c->pk;
      })
    );
    $class::$TABLEDATA['MANDATORY'] = array_keys(
      array_filter($class::$TABLEDATA['FIELD'], function($c){
        return $c->notNull;
      })
    );
  }

  /**
   * Method that returns all records from a table in a database
   *
   * @return array Array of all model type objects found in the table
   */
  public static function searchAll(){
    return self::$con->searchAll(static::$TABLEDATA['TABLENAME'], get_called_class());
  }

  /**
   * verifyType
   *
   * Verifies whether a data type matches the type requested
   *
   * @todo What if the type is unknown? one warning? an error? anything?
   * @param mixed $value Data to check its type
   * @param string $type Type to verify
   * @return bool True if the data matches the type requested
   */
  private static function verifyType($value, $type){
    $func = self::$mapFuncType[strtolower($type)];
    return $func($value);
  }

  /**
   * verifyArrayType
   *
   * Check if an associative array "fieldName => value" has the right kinds
   *
   * @param array $data Associative array to test
   * @return bool Returns true if the data is correct
   */
  private static function verifyArrayType(array $data){
      foreach($data as $fieldName => $value){
        $type = static::$TABLEDATA['FIELD'][$fieldName]->type;
        if(!self::verifyType($value, $type)){
          return false;
        }
      }
      return true;
  }

}

