<?php

class Imagen extends Modelo{
  
  public static $DATOSTABLA = array(
    "NOMBRETABLA" => "imagenes"
  );

  /**
   * Constructor
   * 
   * @param id integer Identificador del registro
   */
  function __construct($id){
    parent::__construct($id);
  }
  
}
