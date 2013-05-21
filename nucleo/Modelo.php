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
   * @param id integer Identificador del registro
   * @todo generar una excepcion si los datos del array no concuerdan con las columnas de la tabla (obligatorios)
   * @todo generar una excepcion si no se ingresan bien el número de argumentos pk
   */
  function __construct(){
    if(func_num_args()==1){
      $arg = func_get_arg(0);
      if(is_array($arg)){
        //Crear una instancia con los datos dados 
        $this->datos = $arg;
      }else{
        //Buscar los datos dado un único id
        $this->datos = self::$con->buscarXPK($arg, $this::NOMBRETABLA);
      }
    }else{
      //Buscar los datos dado varios ids
      $this->datos = self::$con->buscarXPK(func_get_args(), $this::NOMBRETABLA);
    }
  }
  
  /**
   * Método para consultar propiedades del modelo
   *
   * @param propiedad string Propiedad a consultar
   * @todo si ingreso una propiedad que no existe en la tabla debería generar una excepción
   * @return TODO
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
   * @return TODO
   */
  public static function buscarTodos(){
    return self::$con->buscarTodos(static::NOMBRETABLA, get_called_class());
  }

}

