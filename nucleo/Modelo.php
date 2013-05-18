<?php

trait MetodosEstaticos{

  public static function __callStatic($metodo, $argumentos){
    if($argumentos) $argumentos = $argumentos[0];
    $argumentos["__nombreTabla"] = self::$nombre;
    return call_user_func( array("Modelo", "__" . $metodo), $argumentos );
  }

}

abstract class Modelo{

  private static $con;

  public static function static_init(){
    self::$con = new ConectorSQLite();
  }

  public static function __buscarTodos($parametros){
    return self::$con->buscarTodos($parametros['__nombreTabla']);
  }

}

Modelo::static_init();

