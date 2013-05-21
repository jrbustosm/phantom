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
  private $id;         //Identificador del registro
  private $datos;      //Datos almacenados en el registro

  /**
   * Constructor
   * 
   * @param id integer Identificador del registro
   */
  function __construct($id){
    $this->id = $id;
    $this->datos = self::$con->buscarXPK($id, $this::NOMBRETABLA);
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
   * Método que retorna todos los registros de una base de datos de acurdo a 
   * unos parametros:
   *
   * @todo en estos momentos no esta devolviendo objetos si no un arreglo de datos
   */
  public static function buscarTodos(){
    return self::$con->buscarTodos(static::NOMBRETABLA);
  }

}

//Inicializamos los atributos de clase de la clase Modelo
Modelo::static_init();

