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
 * Es la representación de una tabla de una base de datos en un modelo POO, si se
 * desea heredar de esta clase se recomienda usar en conjunto con el trait 
 * MetodosEstaticos {@link MetodosEstaticos}
 *
 * @property ConectorBD con Manejador de Base de Datos
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see MetodosEstaticos
 * @see ConectorBD
 */
abstract class Modelo{

  private static $con; //Manejador de base de datos

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
   * <ul>
   *   <li>__nombreTabla: Nombre de la tabla en donde va a buscar los datos</li>
   * </ul>
   *
   * @param array parametros Arreglo asociativo con datos de la busqueda
   * @todo en estos momentos no esta devolviendo objetos si no un arreglo de datos
   */
  public static function __buscarTodos($parametros){
    return self::$con->buscarTodos($parametros['__nombreTabla']);
  }

}

//Inicializamos los atributos de clase de la clase Modelo
Modelo::static_init();

