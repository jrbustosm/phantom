<?php

/**
 * Campo
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Campo.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase Campo
 * 
 * Es la representación de una columna de la tabla de una base de datos en un modelo POO
 *
 * @property-read string $nombre Nombre del campo
 * @property-read string $tipo Tipo de datos de la columna (ej. integer, text, etc.)
 * @property-read bool $noNulo Indica si el campo es obligatorio o no
 * @property-read scalar $valorDefecto Valor por defecto en el caso de que no sea obligatorio
 * @property-read bool $pk Indica si el campo es una llave primaria
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see Modelo
 */
class Campo{

  private $nombre;
  private $tipo;
  private $noNulo;
  private $valorDefecto;
  private $pk;

  /**
   * __constructor($nombre, $tipo, $noNulo, $valorDefecto, $pk)
   * __construc(array $datos, array $mapa)
   *
   * Ejemplo de datos y mapa
   *
   * <code><pre>
   * $datos = array(
   *   "ej1" => "nombreFoo",
   *   "ej2" => "tipoFoo",
   *   "ej3" => false,
   *   "ej4" => "",
   *   "ej5" => false
   * );
   *
   * $mapa = array(
   *   "nombre" => "ej1",
   *   "tipo" => "ej2",
   *   "noNulo" => "ej3",
   *   "valorDefecto" => "ej4",
   *   "pk" => "ej5"
   * );
   * </pre></code>
   * 
   * @param string $nombre Nombre del campo
   * @param string $tipo Tipo de datos de la columna (ej. integer, text, etc.)
   * @param bool $noNulo Indica si el campo es obligatorio o no
   * @param scalar $valorDefecto Valor por defecto en el caso de que no sea obligatorio
   * @param bool $pk Indica si el campo es una llave primaria
   * @param array $datos Arreglo asociativo con la información sobre el campo
   * @param array $mapa Arreglo asociativo que mapea las llaves de los datos con
   *        las propiedades de la clase Campo
   */
  function __construct(){
    if(func_num_args()==5){
      $this->nombre = func_get_arg(0);
      $this->tipo = func_get_arg(1);
      $this->noNulo = func_get_arg(2);
      $this->valorDefecto = func_get_arg(3);
      $this->pk = func_get_arg(4);
    }else if(func_num_args()==2){
      //Si se ingresan dos parametros estos deben ser arreglos
      if(!is_array(func_get_arg(0)) || !is_array(func_get_arg(1)))
        throw new Exception('Datos incorrectos. No son arreglos');
      $datos = func_get_arg(0);
      $mapa = func_get_arg(1);
      $keys = get_class_vars(__class__);
      $diffKeys = array_diff_key($keys, $mapa);
      if($diffKeys){
        //Si el archivo mapa no tiene las mismas llaves que las propiedades de la 
        //clase Campo se genera una excepción
        throw new Exception('El Mapa esta mal descrito');
      }else{
        foreach(array_keys($keys) as $k){
          if(!array_key_exists($mapa[$k], $datos))
            //Si los datos no tienen los datos completos
            throw new Exception('Datos incorrectos para fabricar campo');
          $this->$k = $datos[$mapa[$k]];
        }
      }
    }else{
      throw new Exception('Datos incorrectos');
    }
    //Se debe comprobar el tipo y la integridad de la información
    if(!is_string($this->nombre))
      throw new Exception('Nombre de campo erroneo.');
    if(!is_string($this->tipo))
      throw new Exception('Tipo de campo erroneo.');
    if(!(is_bool($this->noNulo) || is_int($this->noNulo)))
      throw new Exception('No se puede construir el campo. No nulo debe ser bool');
    $this->noNulo = (bool)$this->noNulo;
    if(!(is_scalar($this->valorDefecto) || $this->valorDefecto==""))
      throw new Exception('No se puede construir el campo. Valor por defecto debe ser escalar');
    if(!(is_bool($this->pk) || is_int($this->pk)))
      throw new Exception('No se puede construir el campo. PK debe ser bool');
    $this->pk = (bool)$this->pk;
  }

  /**
   * Método para consultar propiedades del campo
   *
   * @param string $propiedad Propiedad a consultar
   * @return mixed Valor de la propiedad solicitada
   */
  public function __get($propiedad){
    return $this->$propiedad;
  }

}
