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

  /**
   *
   * @todo se puede mejorar con generadores php 5.5
   */
  public function buscar($tabla, $where="", $class=""){
    $sql = "SELECT * FROM $tabla";
    if($where) $sql .= " WHERE $where";
    $registros = $this->manejador->query($sql);
    return $this->toArray($registros, $class);
  }
  
  public function desc($tabla){
    $sql = "PRAGMA table_info($tabla)";
    $registros = $this->manejador->query($sql);
    $v = $this->toArray($registros);
    $campos = array();
    $mapa = array(
      "nombre"=>"name",
      "pk"=>"pk",
      "noNulo"=>"notnull",
      "valorDefecto"=>"dflt_value",
      "tipo"=>"type",
    );
    foreach($v as $fila){
      array_push($campos, new Campo($fila, $mapa));
    }
    return $campos;
  }

  private function toArray($rs, $class=""){
    $resultados = array();
    while ($reg = $rs->fetchArray()) {
      if($class) array_push($resultados, new $class($reg));
      else array_push($resultados, $reg);
    }
    return $resultados;
  }

}
