<?php

include 'conf/conf.php';

/**
 * __autoload
 *
 * Autoload function class
 *
 * @param string $casllName Name of the class to include
 */
function __autoload($className) {
  //Directories where to look for classes
  $dirs = array("core/","project/control/","project/model/");
  foreach($dirs as $d){
    if(file_exists($d . $className . '.php')){
      include_once $d . $className . '.php';
      if($className == "Model"){
        //Initialize the class attributes of the class Model
        Model::static_init();
      }else if(is_subclass_of($className, "Model")){
        //Initialize the table attributes in particular: the fields that compose
        $className::loadDesc();
      }
      return;
    }
  }
}

/**
 * Phantom
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Phantom.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Class Phantom
 * 
 * framework main class Phantom
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @version $Id$
 * @package core
 * @since 0.1
 */
class Phantom{

  /**
   * array get_url($base)
   *
   * @return array Array with the data from the url,
   *         in the first position the control in the second action to execute,
   *         and the third onwards the parameters of the request
   */
  private static function get_url() {
    $parameters = array();
    $base = str_replace("/","\/",$GLOBALS['_URLBASE']);
    //We sanitation in the Request URI
    $url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    //Extract the URL path
    $url = parse_url($url);
    //We eliminate the Base of the application
    $url = preg_replace("/$base/", "", $url['path'], 1);
    foreach(explode("/", $url) as $p)
      if ($p!='') $parameters[] = $p;
    return $parameters;
  }

  /**
   * start
   *
   * This method executes the respective action Control
   * and according to the URL of the user's request,
   * in the framework phantom urls have the following structure:
   *
   * http://URLBASE/control/action/parameters/...
   *
   */
  public static function start(){

    $ps = self::get_url();

    if(count($ps)==0 || $ps[0]=="index.php"){
      //Assign default control from setup
      $controlName= "${GLOBALS['_CONTROL_INI']}Control"; 
    }else{
      $controlName= "${ps[0]}Control";
    }

    if(in_array($controlName, $GLOBALS['_URLEXCLUDE'])){
      //If found control belongs to one of the directories that are excluded (img, css, js, etc.)
      // It returns the corresponding file if it exists
      if(file_exists($_SERVER['REQUEST_URI'])){
        readfile($_SERVER['REQUEST_URI']);
        exit(0);
      }
    }

    if(class_exists($controlName)){
      $control=new $controlName();
    } else {	
      //If no class is instantiated Driver Error
      $control=new ErrorControl();
    }

    $action = "";
    if(count($ps)>1) $action = $ps[1];

    //Required action is executed, passing the parameters of the request
    $control->runAction($action, $ps);
  }

}
