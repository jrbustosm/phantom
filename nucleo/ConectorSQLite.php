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

  public function buscarTodos($tabla){
    return $this->buscar($tabla);
  }

  public function buscarXPK($id, $tabla){
    return $this->buscar($tabla, "id=$id")[0];
  }
  
  public function buscar($tabla, $where=""){
    $sql = "SELECT * FROM $tabla";
    if($where) $sql .= " WHERE $where";
    $registros = $this->manejador->query($sql);
    $resultados = array();
    while ($reg = $registros->fetchArray()) {
      array_push($resultados, $reg);
    }
    return $resultados;
  }
  
}
