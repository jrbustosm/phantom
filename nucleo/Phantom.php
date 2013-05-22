<?php

include 'conf/conf.php';

/*
 * Función para la autocarga de clases
 *
 */
function __autoload($nombre_clase) {
  //Directorios donde buscar las clases
  $dirs = array("nucleo/","proyecto/control/","proyecto/modelo/");
  foreach($dirs as $d){
    if(file_exists($d . $nombre_clase . '.php')){
      include $d . $nombre_clase . '.php';
      if($nombre_clase == "Modelo"){
        //Inicializamos los atributos de clase de la clase Modelo
        Modelo::static_init();
      }
      return;
    }
  }
}

/**
 * Phantom
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Phantom.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase Phantom
 * 
 * Clase principal del framework Phantom
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 */
class Phantom{

  /**
   * array get_url($base)
   *
   * @return array Arreglo con los datos de la url, en la primera posición el control
   *               en la segunda posición la acción a ejecutar, y de la tercera en
   *               adelante los parametros de la petición
   */
  private static function get_url() {
    $parametros = array();
    $base = str_replace("/","\/",$GLOBALS['_URLBASE']);
    //Hacemos un saneamiento en el URI de la solicitud
    $url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    //Extraemos el path de la URL
    $url = parse_url($url)['path'];
    //Eliminamos la Base de la solicitud
    $url = preg_replace("/$base/", "", $url, 1);
    foreach(explode("/", $url) as $p)
      if ($p!='') $parametros[] = $p;
    return $parametros;
  }

  /**
   * iniciar
   *
   * Este método ejecuta el Control y accion respectivos de acuerdo a la URL 
   * de la petición del usuario, en el framework phantom las urls tienen la
   * siguiente estructura: 
   *
   * http://URLBASE/control/accion/parametros/...
   *
   */
  public static function iniciar(){

    $ps = self::get_url();

    if(count($ps)==0 || $ps[0]=="index.php"){
      //Asignamos el control por defecto desde la configuración
      $controlname= "${GLOBALS['_CONTROL_INI']}Control"; 
    }else{
      $controlname= "${ps[0]}Control";
    }

    if(in_array($controlname, $GLOBALS['_URLEXCLUIR'])){
      //Si el control encontrado pertenece a uno de los directorios que se excluyen
      //por ejemplo: img, css, js, etc., se retorna el respectivo archivo si este
      //existe
      if(file_exists($_SERVER['REQUEST_URI'])){
        readfile($_SERVER['REQUEST_URI']);
        exit(0);
      }
    }

    if(class_exists($controlname)){
      $control=new $controlname();
    } else {	
      //Si la clase no exsite se crea una instancia del controlador Error
      $control=new ErrorControl();
    }

    $accion = "";
    if(count($ps)>1) $accion = $ps[1];

    //Se ejecuta la acción requerida, pasansole los parametros de la petición
    $control->ejecutarAccion($accion, $ps);
  }

}
