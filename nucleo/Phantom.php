<?php

include 'conf/conf.php';

function __autoload($nombre_clase) {
  $dirs = array("nucleo/","proyecto/control/","proyecto/modelo/");
  foreach($dirs as $d){
    if(file_exists($d . $nombre_clase . '.php')){
      include $d . $nombre_clase . '.php';
      if($nombre_clase == "Modelo"){
        //Inicializamos los atributos de clase de la clase Modelo
        Modelo::static_init();
      }
      return;
    }
  }
}

class Phantom{

  private static function get_url($base) {
    $parametros = array();
    $base = str_replace("/","\/",$base);
    $url = preg_replace("/$base/", "", $_SERVER['REQUEST_URI'], 1);
    $url = parse_url($url);
    foreach(explode("/", $url['path']) as $p)
      if ($p!='') $parametros[] = $p;
    return $parametros;
  }

  public static function iniciar(){
    global $_URLBASE, $_URLEXCLUIR;
    $ps = self::get_url($_URLBASE);

    if(count($ps)==0 || $ps[0]=="index.php"){
      //Asignamos el control por defecto
      $controlname= "${GLOBALS['_CONTROL_INI']}Control"; 
    }else{
      $controlname= "${ps[0]}Control";
    }

    if(in_array($controlname, $_URLEXCLUIR)){
      if(file_exists($_SERVER['REQUEST_URI'])){
        readfile($_SERVER['REQUEST_URI']);
        exit(0);
      }
    }

    if(class_exists($controlname)){
      $control=new $controlname();
    } else {	
      $control=new ErrorControl();
    }

    $accion = "";
    if(count($ps)>1) $accion = $ps[1];
    $control->ejecutarAccion($accion, $ps);
  }

}
