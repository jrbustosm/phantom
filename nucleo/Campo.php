<?php

class Campo{

  private $nombre;
  private $tipo;
  private $noNulo;
  private $valorDefecto;
  private $pk;

  function __construct(){
    if(func_num_args()==5){
      $this->nombre = func_get_arg(0);
      $this->tipo = func_get_arg(1);
      $this->noNulo = func_get_arg(2);
      $this->valorDefecto = func_get_arg(3);
      $this->pk = func_get_arg(4);
    }else if(func_num_args()==2){
      if(!is_array(func_get_arg(0)) || !is_array(func_get_arg(1)))
        throw new Exception('Datos incorrectos. No son arreglos');
      $datos = func_get_arg(0);
      $mapa = func_get_arg(1);
      $keys = get_class_vars(__class__);
      $diffKeys = array_diff_key($keys, $mapa);
      if($diffKeys){
        throw new Exception('El Mapa esta mal descrito');
      }else{
        foreach(array_keys($keys) as $k){
          if(!array_key_exists($mapa[$k], $datos))
            throw new Exception('Datos incorrectos para fabricar campo');
          $this->$k = $datos[$mapa[$k]];
        }
      }
    }else{
      throw new Exception('Datos incorrectos');
    }
    if(!is_string($this->nombre))
      throw new Exception('Nombre de campo erroneo.');
    if(!is_string($this->tipo))
      throw new Exception('Tipo de campo erroneo.');
    if(!(is_bool($this->noNulo) || is_int($this->noNulo)))
      throw new Exception('No se puede construir el campo. No nulo debe ser bool');
    if(!(is_scalar($this->valorDefecto) || $this->valorDefecto==""))
      throw new Exception('No se puede construir el campo. Valor por defecto debe ser escalar');
    if(!(is_bool($this->pk) || is_int($this->pk)))
      throw new Exception('No se puede construir el campo. PK debe ser bool');
  }

  public function __get($propiedad){
    return $this->$propiedad;
  }

}
