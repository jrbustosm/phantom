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
 * @todo este trait puede ser reemplazado por el Uso de Enlaces Estáticos en Tiempo de ejecución para php 5.3
 */
trait MetodosEstaticos{

  /**
   + Método que llama los métodos estaticos de la clase padre, especialmente
   * diseñado para las clases que heredan de la clase Modelo {@link Modelo}
   *
   * @param string metodo Nombre del método estatico a ejecutar
   * @param array argumentos Arreglo con los parametros de la llamada 
   */
  public static function __callStatic($metodo, array $argumentos){
    if($argumentos) $argumentos = $argumentos[0];
    $argumentos["_nombreTabla"] = self::NOMBRE;
    return call_user_func( array("Modelo", "_" . $metodo), $argumentos );
  }

}

