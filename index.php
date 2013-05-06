<?php


function get_url() {
  $parametros = array();
  $url = parse_url($_SERVER['REQUEST_URI']);
  foreach(explode("/", $url['path']) as $p)
    if ($p!='') $parametros[] = $p;
  return $parametros;
}

print_r($_GET);
print_r(get_url());


