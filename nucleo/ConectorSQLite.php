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
    $registros = $this->manejador->query("SELECT * from $tabla");
    $resultados = array();
    while ($reg = $registros->fetchArray()) {
      array_push($resultados, $reg);
    }
    return $resultados;
  }

  public function buscarXPK($id, $tabla){
    $registro = $this->manejador->query("SELECT * FROM $tabla WHERE id = $id");
    return $registro->fetchArray();
  }
  
}
