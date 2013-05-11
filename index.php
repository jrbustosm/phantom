<?php

include 'nucleo/Control.php';
include 'nucleo/ConectorBD.php';
include 'nucleo/ConectorSQLite.php';
include 'proyecto/control/principal.php';
include 'proyecto/control/imagen.php';
include 'proyecto/control/Error.php';

function get_url() {
  $parametros = array();
  $url = parse_url($_SERVER['REQUEST_URI']);
  foreach(explode("/", $url['path']) as $p)
    if ($p!='') $parametros[] = $p;
  return $parametros;
}

$ps=get_url();

if(count($ps)<=1 || $ps[1]=="index.php"){
  //Accinamos el control por defecto
  $controlname="Principal"; 
}else{
  $controlname=$ps[1]; //TODO: no siempre esta en 1	
}

if(class_exists($controlname)){
  $control=new $controlname();
} else {	
	$control=new Error();
}

$accion = "";
if(count($ps)>1) $accion = $ps[2]; //TODO: no siempre esta en 2
$control->ejecutarAccion($accion);

