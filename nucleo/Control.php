<?php

/**
 * Control
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Control.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase Control
 * 
 * Maneja las acciones a efectuar de acuerdo a una solicitud
 * en teoria los controladores usan los modelos para obtener información
 * pasando estos datos a las vistas
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 */
abstract class Control{

  /**
   * Este método Ejecuta la accion indicada, si la accion no existe ejecuta el método
   * 'accionError', si no se indica ninguna accion ejecuta el método 'porDefecto'
   *
   * @param string accion Accion a ejecutar
   * @param array parametros Arreglo asociativo con los parametros de la solicitud
   */
  public function ejecutarAccion($accion="", array $parametros=array()){
    if($accion=="") $this->porDefecto($parametros);
    else{
      if(method_exists($this, $accion)){
        $this->$accion($parametros);
      } else {
        $this->accionError($parametros);
      }
    }
  }

  /**
   * Método que se ejecuta por defecto si no se indica una acción
   *
   * @param array parametros Arreglo asociativo con los parametros de la solicitud
   */
  public function porDefecto(array $parametros){
    echo 'Hola Mundo!!!';
  }

  /**
   * Método que se ejecuta si se indica una acción inexistente, por defecto se ejecuta
   * la acción "porDefecto"
   *
   * @param array parametros Arreglo asociativo con los parametros de la solicitud
   */
  public function accionError(array $parametros){
    $this->porDefecto($parametros);
  }

  /**
    Ejecuta una vista determinada, convirtiendo un arreglo asociativo a variables
    para que sean mas faciles de usar en la vista

    @param string vista Nombre de la vista a mostrar
    @param array datos Arreglo asociativos con los datos a mostrar en la vista
    @todo mejorar usando templates
   */
  protected function mostrarVista($vista, array $datos){
    foreach($datos as $llave => $valor) $$llave = $valor;
    include("proyecto/vista/" . $vista . ".php");
  }

}
