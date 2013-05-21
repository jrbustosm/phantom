<?php

class conectorSQLite extends ConectorBD{

  function __construct(){
    parent::__construct();
  }

  function __destruct(){
    parent::__destruct();
  }

  public function abrir(){
    $this->manejador=new SQLite3($GLOBALS['_BDNOMBRE']);
  }

  public function cerrar(){
    $this->manejador->close();
  }

  public function ejecutar($sql){
    return $this->manejador->exec($sql);
  }

  public function buscarTodos($tabla, $class=""){
    return $this->buscar($tabla, "", $class);
  }

  public function buscarXPK($id, $tabla, $class=""){
    return $this->buscar($tabla, "id=$id", $class)[0];
  }
  
  /**
   *
   * @todo se puede mejorar con generadores php 5.5
   */
  public function buscar($tabla, $where="", $class=""){
    $sql = "SELECT * FROM $tabla";
    if($where) $sql .= " WHERE $where";
    $registros = $this->manejador->query($sql);
    $resultados = array();
    while ($reg = $registros->fetchArray()) {
      if($class) array_push($resultados, new $class($reg));
      else array_push($resultados, $reg);
    }
    return $resultados;
  }
  
}
