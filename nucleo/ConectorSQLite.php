<?php

/**
 * ConectorSQLite
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/ConectorSQLite.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase ConectorSQLite
 * 
 * Adaptador para manejar una conexión a una base de datos en SQLite
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see ConectorBD
 */
class ConectorSQLite extends ConectorBD{

  /**
   * abrir
   *
   * Almacena dentro del atributo manejador, un recurso de conexión valido con 
   * el manejador de base de datos SQLite
   *
   * @override
   */
  public function abrir(){
    $this->manejador=new SQLite3($GLOBALS['_BDNOMBRE']);
  }

  /**
   * cerrar
   *
   * Termina la conexión con el manejador de base de datos SQLite
   *
   * @override
   */
  public function cerrar(){
    $this->manejador->close();
  }

  /**
   * ejecutar
   *
   * Ejecuta una sentencia SQL en el manejador de Bases de Datos
   *
   * @param string $sql Sentencia SQL a ejecutar
   * @return mixed El sesultado de ejecutar esta sentencia
   * @override
   */
  public function ejecutar($sql){
    return $this->manejador->exec($sql);
  }

  /**
   * buscar
   *
   * Busca un grupo de registros en una tabla de acuerdo a ciertos criterios
   *
   * @todo se puede mejorar con generadores php 5.5
   * @param string $tabla Nombre de la tabla donde buscar los datos
   * @param string $where Criterios de busqueda de la sentencia select en formato SQL
   * @param string $class Nombre de la clase con la que se generá las instancias de 
   *                     la salida, si es igual a vacio se retorna un arreglo de arreglos
   * @return array Un arreglo de objetos de tipo class o arrays, como resultado de buscar
   *         los registros en la tabla y criterios de indicados
   * @override
   */
  public function buscar($tabla, $where="", $class=""){
    $sql = "SELECT * FROM $tabla";
    if($where) $sql .= " WHERE $where";
    $registros = $this->manejador->query($sql);
    return $this->toArray($registros, $class);
  }
  
  /**
   * desc
   *
   * Busca la descripcción de las columnas de una tabla en una base de datos de SQLite
   *
   * @param string $tabla Nombre d ela tabla a describir
   * @return array Un arreglo asociativo de Objetos de tipo Campos
   * @override
   */
  public function desc($tabla){
    $sql = "PRAGMA table_info($tabla)";
    $registros = $this->manejador->query($sql);
    $v = $this->toArray($registros);
    //Array para mapear los nombres de las llaves requeridas con las retornadas 
    //por SQLite
    $mapa = array(
      "nombre"=>"name",
      "pk"=>"pk",
      "noNulo"=>"notnull",
      "valorDefecto"=>"dflt_value",
      "tipo"=>"type",
    );
    $campos = array();
    foreach($v as $fila){
      $campos[$fila[$mapa["nombre"]]] = new Campo($fila, $mapa);
    }
    return $campos;
  }
  
  /**
   * toArray
   *
   * Convierte una busqueda a un Array
   *
   * @param resource $rs Busqueda echa a la base de datos
   * @param string $class Nombre de la clase con la que se generá las instancias de 
   *                     la salida, si es igual a vacio se retorna un arreglo de arreglos
   * @return array Arreglo de objetos de tipo class
   */
  private function toArray($rs, $class=""){
    $resultados = array();
    while ($reg = $rs->fetchArray()) {
      if($class) array_push($resultados, new $class($reg));
      else array_push($resultados, $reg);
    }
    return $resultados;
  }

}
