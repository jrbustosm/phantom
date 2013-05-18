<?php

class ErrorControl extends Control{
  function porDefecto($parametros){
    echo "la pagina no existe ";
    print_r($parametros);
  }
}
