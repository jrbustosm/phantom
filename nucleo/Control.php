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
@todo hacer metodo ejecutarAccion para centralizar
*/
abstract class Control{

  /**
  <p>Método ejecutarAccion:<br/>
  <br/>
  Ejecutar la accion indicada
  </p>

  @access public
  @param string accion Accion a ejecutar
  @param array parametros Arreglo asociativo con los parametros de la solicitud
  @return void
  */
  public function ejecutarAccion($accion, $parametros){
    if($accion=="") $this->porDefecto($parametros);
    if(method_exists($this, $accion)){
      $this->$accion($parametros);
    } else {
      $this->accionError($parametros);
    }
  }

  /**
  <p>Método porDefecto:<br/>
  <br/>
  Método que se ejecuta por defecto si no se indica una acción<br/>
  </p>

  @access public
  @param array parametros Arreglo asociativo con los parametros de la solicitud
  @return void
  */
  public function porDefecto($parametros){
    echo 'Hola Mundo!!!';
  }

  /**
  <p>Método accionError:<br/>
  <br />
  Método que se ejecuta si se indica una acción inexistente<br />
  </p>

  @access public
  @param array parametros Arreglo asociativo con los parametros de la solicitud
  @return void
  */
  public function accionError($parametros){
    $this->porDefecto($parametros);
  }

  /**
  <p>Método mostrarVista:<br/>
  <br/>
  Ejecuta una vista determinada, convirtiendo un arreglo asociativo a variables<br/>
  para que sean mas faciles de usar en la vista
  </p>

  @access protected
  @param string vista Nombre de la vista a mostrar
  @param array datos Arreglo asociativos con los datos a mostrar en la vista
  @return void
  @todo mejorar usando templates
  */
  protected function mostrarVista($vista, $datos){
    foreach($datos as $llave => $valor) $$llave = $valor;
    include("proyecto/vista/" . $vista . ".php");
  }

}
