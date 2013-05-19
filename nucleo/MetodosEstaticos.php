<?php

/**
 * Trait MetodosEstaticos
 *
 * Rasgo para hacer funcionar los métodos estaticos en las clases que hereden
 * de la clase Modelo {@link Modelo}
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see Modelo
 */
trait MetodosEstaticos{

  /**
   + Método que llama los métodos estaticos de la clase padre, especialmente
   * diseñado para las clases que heredan de la clase Modelo {@link Modelo}
   *
   * @param string metodo Nombre del método estatico a ejecutar
   * @param array argumentos Arreglo con los parametros de la llamada 
   */
  public static function __callStatic($metodo, $argumentos){
    if($argumentos) $argumentos = $argumentos[0];
    $argumentos["_nombreTabla"] = self::$nombre;
    return call_user_func( array("Modelo", "_" . $metodo), $argumentos );
  }

}

