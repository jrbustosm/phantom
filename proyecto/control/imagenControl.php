<?php

class imagenControl extends Control{

  public function porDefecto($parametros){
    $this->listar($parametros);
  }

  public function listar($parametros){
    $this->mostrarVista("listarImagenes", ["imagenes" => Imagen::buscarTodos()]);
  }

} 
