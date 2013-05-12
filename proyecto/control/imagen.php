<?php

class imagen extends Control{
  public function porDefecto($parametros){
    echo "Hola soy imagen por defecto";
  }

  public function listar($parametros){
    $con = new ConectorSQLITE();
    $v = $con->buscarTodos("Imagenes");
    $datos = array(
      "imagenes" => $v
    );
    $this->mostrarVista("listarImagenes", $datos);
  }
} 
