<?php

/**
 * Field
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Campo.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Class Field
 * 
 * Is a representation of a table column in a database a model POO
 *
 * @property-read string $name name of field
 * @property-read string $type Data type of the column (integer, text, etc.)
 * @property-read bool $notNull Indicates whether the field is required or not
 * @property-read scalar $defaultvalue Default value if not required
 * @property-read bool $pk Indicates whether the field is a primary key
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @version $Id$
 * @package core
 * @since 0.1
 * @see Model
 */
class Field{

  private $name;
  private $type;
  private $notNull;
  private $defaultValue;
  private $pk;

  /**
   * __construct($name, $type, $notNull, $defaultValue, $pk)
   * __construct(array $data, array $map)
   *
   * instance data and map
   *
   * <code><pre>
   * $data = array(
   *   "ej1" => "nameFoo",
   *   "ej2" => "typeFoo",
   *   "ej3" => false,
   *   "ej4" => "",
   *   "ej5" => false
   * );
   *
   * $map = array(
   *   "name" => "ej1",
   *   "type" => "ej2",
   *   "notNull" => "ej3",
   *   "defaultValue" => "ej4",
   *   "pk" => "ej5"
   * );
   * </pre></code>
   * 
   * @param string $name name of field
   * @param string $type Data type of the column (integer, text, etc.)
   * @param bool $notNull Indicates whether the field is required or not
   * @param scalar $defaultValue Default value if not required
   * @param bool $pk Indicates whether the field is a primary key
   * @param array $data Associative array with information about the field
   * @param array $map Associative array that maps the keys of the data with the Field class properties
   */
  function __construct(){
    if(func_num_args()==5){
      $this->name = func_get_arg(0);
      $this->type = func_get_arg(1);
      $this->notNull = func_get_arg(2);
      $this->defaultValue = func_get_arg(3);
      $this->pk = func_get_arg(4);
    }else if(func_num_args()==2){
      //If two parameters are entered they must be array
      if(!is_array(func_get_arg(0)) || !is_array(func_get_arg(1)))
        throw new Exception('incorrect data. not array');
      $data = func_get_arg(0);
      $map = func_get_arg(1);
      $keys = get_class_vars(__class__);
      $diffKeys = array_diff_key($keys, $map);
      if($diffKeys){
        //If the map file has the same keys that the Field class properties generates an exception
        throw new Exception('The Map is poorly described');
      }else{
        foreach(array_keys($keys) as $k){
          if(!array_key_exists($map[$k], $data))
            //If the data does not have the complete data
            throw new Exception('Incorrect data to make field');
          $this->$k = $data[$map[$k]];
        }
      }
    }else{
      throw new Exception('incorrect data');
    }
    //You should check the type and completeness of the information
    if(!is_string($this->name))
      throw new Exception('Field name wrong.');
    if(!is_string($this->type))
      throw new Exception('Wrong field type.');
    if(!(is_bool($this->notNull) || is_int($this->notNull)))
      throw new Exception('You can not build the field. notNull be bool');
    $this->notNull = (bool)$this->notNull;
    if(!(is_scalar($this->defaultValue) || $this->defaultValue==""))
      throw new Exception('You can not build the field. Default value must be scalar');
    if(!(is_bool($this->pk) || is_int($this->pk)))
      throw new Exception('You can not build the field. PK be bool');
    $this->pk = (bool)$this->pk;
  }

  /**
   * Method to query field properties
   *
   * @param string $property Property to consult
   * @return mixed Value of the requested property
   */
  public function __get($property){
    return $this->$property;
  }

}
