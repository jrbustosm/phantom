<?php

/**
<p>Clase Control:<br />
<br />
Maneja las acciones a efectuar de acuerdo a una solicitud,<br/>
en teoria los controladores usan los modelos para obtener información<br />
pasando esta a las vistas<br />
</p>

@abstract
@author uniminuto
@link https://github.com/jrbustosm/phantom/blob/master/nucleo/Control.php
@package nucleo
@version 0.1
*/
abstract class Control{

  /**
  <p>Metodo porDefecto:<br/>
  <br/>
  Método que se ejecuta por defecto si no se indica una acción<br/>
  </p>

  @param array parametros Arreglo asociativo con los parametros de la solicitud
  @return void
  */
  public function porDefecto($parametros){
    echo 'hola';
  }

  /**
  <p>
  </p>

  @param string vista Nombre de la vista a mostrar
  @param array datos Arreglo asociativos con los datos a mostrar en la vista
  @todo mejorar usando templates
  */
  protected function mostrarVista($vista, $datos){
    foreach($datos as $llave => $valor) $$llave = $valor;
    include("proyecto/vista/" . $vista . ".php");
  }

}
