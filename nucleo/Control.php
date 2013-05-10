<?php
abstract class Control{
  public function porDefecto($parametros){
    echo 'hola';
  }
  protected function mostrarVista($vista, $datos){
    foreach($datos as $llave => $valor) $$llave = $valor;
    include("proyecto/vista/" . $vista . ".php");
  }
}
