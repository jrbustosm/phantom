<?
class conectorSQLite extends ConectorBD{

  function __construct(){
    parent::__construct();
  }

  function __destruct(){
    parent::__destruct();
  }

  public function abrir(){
    $this->manejador=new SQLite3("datos/mi.bd");
  }

  public function cerrar(){
    $this->manejador->close();
  }

  public function ejecutar($sql){
    return $this->manejador->exec($sql);
  }

}
