<?php

class imagenControl extends Control{

  public function porDefecto(array $parametros){
    $this->listar($parametros);
  }

  public function listar(array $parametros){
    $this->mostrarVista("listarImagenes", ["imagenes" => Imagen::buscarTodos()]);
  }

} 
