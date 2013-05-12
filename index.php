<?php

include 'conf/conf.php';
include 'nucleo/Control.php';
include 'nucleo/ConectorBD.php';
include 'nucleo/ConectorSQLite.php';
include 'proyecto/control/principal.php';
include 'proyecto/control/imagen.php';
include 'proyecto/control/Error.php';

function get_url($base) {
  $parametros = array();
  $base = str_replace("/","\/",$base);
  $url = preg_replace("/$base/", "", $_SERVER['REQUEST_URI'], 1);
  $url = parse_url($url);
  foreach(explode("/", $url['path']) as $p)
    if ($p!='') $parametros[] = $p;
  return $parametros;
}

$ps=get_url($_URLBASE);

if(count($ps)==0 || $ps[0]=="index.php"){
  //Asignamos el control por defecto
  $controlname="Principal"; 
}else{
  $controlname=$ps[0];
}

if(in_array($controlname, $_EXCLUDE)){
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

