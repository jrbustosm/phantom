<?
abstract class ConectorBD{

  protected $manejador;

  function __construct(){
    $this->abrir();
  }

  function __destruct(){
    $this->cerrar();
  }

  abstract public function abrir();
  abstract public function cerrar();
  abstract public function ejecutar($sql);
  abstract public function buscarTodos($tabla);
  abstract public function buscarXPK($id, $tabla);

}
