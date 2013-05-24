<?

/**
 * ConectorBD
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Modelo.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase ConectorBD
 * 
 * Clase creada para describir el comportamiento de un manejador de base de datos
 *
 * @property Recurse manejador Connexión a la base de datos
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see ConectorSQLite
 */
abstract class ConectorBD{

  protected $manejador;

  function __construct(){
    $this->abrir();
  }

  function __destruct(){
    $this->cerrar();
  }

  /**
   * abrir
   */
  abstract public function abrir();

  /**
   * cerrar
   */
  abstract public function cerrar();

  /**
   * ejecutar
   */
  abstract public function ejecutar($sql);

  /**
   * buscarTodos
   */
  public function buscarTodos($tabla, $class=""){
    return $this->buscar($tabla, "", $class);
  }

  /**
   * buscarXPK
   * @todo mejorar IDs
   */
  public function buscarXPK($id, $tabla, $class=""){
    $v = $this->buscar($tabla, "id=$id", $class);
    return $v[0];
  }
  
  /**
   * buscar
   */
  abstract public function buscar($tabla, $where);

  abstract public function desc($tabla);

}
