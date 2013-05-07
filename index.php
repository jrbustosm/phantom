<?php
include 'nucleo/control.php';
include 'proyecto/control/principal.php';

function get_url() {
  $parametros = array();
  $url = parse_url($_SERVER['REQUEST_URI']);
  foreach(explode("/", $url['path']) as $p)
    if ($p!='') $parametros[] = $p;
  return $parametros;
}
$control=new Principal();
$control->porDefecto(get_url());


