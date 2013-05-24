<?php

/**
 * Modelo
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Modelo.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase Modelo
 * 
 * Es la representación de una tabla de una base de datos en un modelo POO
 *
 * @property ConectorBD con Manejador de Base de Datos
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see ConectorBD
 */
abstract class Modelo{

  private static $con; //Manejador de base de datos
  private $datos;      //Datos almacenados en el registro

  /**
   * Constructor
   *
   * __construct($id1, [$id2, ... , $idn])
   * __construct(array $datos)
   *
   * @param ids string Identificadores del registro
   * @param datos array Arreglo asociativo con los datos del registro
   * @todo generar una excepcion si los datos del array no concuerdan con las columnas de la tabla (obligatorios)
   * @todo generar una excepcion si no se ingresan bien el número de argumentos pk
   * @todo no olvidar etiqueta exception de phpdoc
   */
  function __construct(){
    if(func_num_args()==1){
      $arg = func_get_arg(0);
      if(is_array($arg)){
        //Crear una instancia con los datos dados 
        $this->datos = $arg;
      }else{
        //Buscar los datos dado un único id
        $this->datos = self::$con->buscarXPK($arg, $this::$DATOSTABLA['NOMBRETABLA']);
      }
    }else{
      //Buscar los datos dado varios ids
      $this->datos = self::$con->buscarXPK(func_get_args(), $this::$DATOSTABLA['NOMBRETABLA']);
    }
  }
  
  /**
   * Método para consultar propiedades del modelo
   *
   * @param propiedad string Propiedad a consultar
   * @todo si ingreso una propiedad que no existe en la tabla debería generar una excepción
   * @return mixed Valor de la propiedad solicitada, si la propiedad existe pero no esta definida retorna NULL
   */
  public function __get($propiedad){
    if(isset($this->datos[$propiedad])) return $this->datos[$propiedad];
    return NULL;
  }

  /**
   * Método que inicializa los atributos de clase
   */
  public static function static_init(){
    //Se selecciona el conector seleccionado en la configuración
    $conclass = "Conector" . $GLOBALS['_BDMOTOR'];
    self::$con = new $conclass();
  }

  /**
   * Método que retorna todos los registros de una tabla de una base de datos
   *
   * @return array Arreglo de con todos los objetos de tipo modelo que se encuentra en la tabla
   */
  public static function buscarTodos(){
    return self::$con->buscarTodos(static::$DATOSTABLA['NOMBRETABLA'], get_called_class());
  }

  public static function cargarDesc(){
    $class = get_called_class();
    $class::$DATOSTABLA['CAMPOS'] = self::$con->desc(static::$DATOSTABLA['NOMBRETABLA']);
  }

}

