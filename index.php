<?php
include 'nucleo/control.php';
include 'proyecto/control/principal.php';
include 'proyecto/control/imagen.php';
function get_url() {
  $parametros = array();
  $url = parse_url($_SERVER['REQUEST_URI']);
  foreach(explode("/", $url['path']) as $p)
    if ($p!='') $parametros[] = $p;
  return $parametros;
}
  $ps= get_url ();
  print_r($ps);
  

