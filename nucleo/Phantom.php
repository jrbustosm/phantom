<?php

include 'conf/conf.php';
include 'nucleo/Control.php';
include 'nucleo/ConectorBD.php';
include 'nucleo/ConectorSQLite.php';
include 'proyecto/control/PrincipalControl.php';
include 'proyecto/control/imagenControl.php';
include 'proyecto/control/ErrorControl.php';

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
      $controlname="PrincipalControl"; 
    }else{
      $controlname=$ps[0] . "Control";
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
      $control=new Error();
    }

    $accion = "";
    if(count($ps)>1) $accion = $ps[1];
    $control->ejecutarAccion($accion, $ps);
  }

}
