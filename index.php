<?php
include 'nucleo/control.php';
include 'proyecto/control/principal.php';
include 'proyecto/control/imagen.php';
include 'nucleo/Error.php';
function get_url() {
  $parametros = array();
  $url = parse_url($_SERVER['REQUEST_URI']);
  foreach(explode("/", $url['path']) as $p)
    if ($p!='') $parametros[] = $p;
  return $parametros;
}
  $ps= get_url ();
 
  $controlname = $ps[1];//TODO: no siempre esta en 1
  if(class_exists ($controlname)){
  $control = new $controlname(); 
  }else{  
    $control=new Error();
  }
  if($control instanceof Error || count($ps)<=2){
    $control-> porDefecto($ps);
  }else{
    $accion = $ps[2];
    $control -> $accion($ps);
  }
