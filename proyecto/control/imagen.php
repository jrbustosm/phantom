<?php

class imagen extends Control{
  public function porDefecto($parametros){
    $this->listar($parametros);
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
