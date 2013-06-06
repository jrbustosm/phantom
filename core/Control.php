<?php

/**
 * Control
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Control.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Class Control
 * 
 * Manages the actions to be performed according to an application in theory controllers
 * using models for information passing this data to views
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @translated to English by German Jair Gomez Figueredo <jairgo.123@gmail.com> 
 * @version $Id$
 * @package core
 * @since 0.1
 */
abstract class Control{

  /**
   * This method executes the specified action if no action executes the method
   * 'actionError', if none is specified action method runs 'byDefault'
   * @param string $action Action to run
   * @param array $parameters Associative array with the parameters of the request
   */
  public function runAction($action="", array $parameters=array()){
    if($action=="") $this->byDefault($parameters);
    else{
      if(method_exists($this, $action)){
        $this->$action($parameters);
      } else {
        $this->actionError($parameters);
      }
    }
  }

  /**
   * Method that runs by default if no action is indicated
   *
   * @param array $parameters Associative array with the parameters of the request
   */
  public function byDefault(array $parameters){
    echo 'Hello World!!!';
  }

  /**
   * Method that runs when an on nonexistent action, default action is executed "byDefault"
   *
   * @param array $parameters Associative array with the parameters of the request
   */
  public function actionError(array $parameters){
    $this->byDefault($parameters);
  }

  /**
  *  Executes a given view, becoming an associative array of variables to be easier to use at the view
*
 *   @param string $view name of view to show
  *  @param array $data Associative Array with the data to display in the view
   * @todo improved by using templates
   */
  protected function showView($view, array $data){
    foreach($data as $key => $value) $$key = $value;
    include("project/view/" . $view . ".php");
  }

}
