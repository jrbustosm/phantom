<?php
class PrincipalControl extends Control{
	
  public function porDefecto($parametros){
    $datos= array(
      "titulo"=>"Mi titulo",
      "contenido"=>"Contenido",
    );
    $this->mostrarVista("por_defecto", $datos);
  }

}  

