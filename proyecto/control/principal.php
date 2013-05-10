<?php
class Principal extends Control{
	
  public function porDefecto($parametros){
    $datos= array(
      "titulo"=>"Mi titulo",
      "contenido"=>"Contenido",
    );
    $this->mostrarVista("pordefecto", $datos);
  }
}  

