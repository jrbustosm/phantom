<?php
include 'nucleo/control.php';
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
//$control=new Principal();
//$control->porDefecto(get_url());
$ps=get_url();
if(count($ps)<=1 || $ps[1]=="index.php"){
  $controlname="Principal";
}else{
  $controlname=$ps[1]; //TODO: no siempre esta en 1	
}
if(class_exists($controlname)){
  $control=new $controlname();
} else {	
	$control=new Error();
   }
if($control instanceof Error || count($ps)<=2){
	$control->porDefecto($ps);
} else {
	$accion=$ps[2]; //TODO: no siempre esta en 2
	if(method_exists($control, $accion)){
		$control->$accion($ps);
	} else {
		$control->porDefecto($ps);
	}
}
