<?php

class imagenControl extends Control{
  public function porDefecto($parametros){
    $this->listar($parametros);
  }

  public function listar($parametros){
    $datos = array(
        "imagenes" => Imagen::buscarTodos()
        );
    $this->mostrarVista("listarImagenes", $datos);
  }
} 
