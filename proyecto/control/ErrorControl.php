<?php

class ErrorControl extends Control{

  function porDefecto(array $parametros){
    echo "la pagina no existe ";
    print_r($parametros);
  }

}
