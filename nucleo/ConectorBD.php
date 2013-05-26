<?

/**
 * ConectorBD
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/ConectorBD.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase ConectorBD
 * 
 * Clase creada para describir el comportamiento de un manejador de base de datos
 *
 * @property resource $manejador Connexión a la base de datos
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see ConectorSQLite
 */
abstract class ConectorBD{

  protected $manejador;

  /**
   * Constructor
   *
   * Abre la conexión con el manejador de base de datos
   *
   */
  function __construct(){
    $this->abrir();
  }

  /**
   * Destructor
   *
   * Cierra la conexión con el manejador de base de datos
   *
   */
  function __destruct(){
    $this->cerrar();
  }

  /**
   * abrir
   *
   * Almacena dentro del atributo manejador, un recurso de conexión valido con 
   * el manejador de base de datos
   *
   */
  abstract public function abrir();

  /**
   * cerrar
   *
   * Termina la conexión con el manejador de base de datos
   *
   */
  abstract public function cerrar();

  /**
   * ejecutar
   *
   * Ejecuta una sentencia SQL en el manejador de Bases de Datos
   *
   * @param string $sql Sentencia SQL a ejecutar
   * @return mixed El sesultado de ejecutar esta sentencia
   */
  abstract public function ejecutar($sql);

  /**
   * buscarTodos
   *
   * Retorna todos los registros de una base de datos
   *
   * @param string $tabla Nombre d ela tabla
   * @param string $class Nombre d ela clase de los objetos que van a ser
   *              retornados, si es vacio retorna un array de arrays
   * @return array Un arreglo con objetos de tipo class o de arreglos con
   *               todos los registros de la tabla solicitada
   */
  public function buscarTodos($tabla, $class=""){
    return $this->buscar($tabla, "", $class);
  }

  /**
   * buscarXPK
   *
   * Busca el registro que tenga el (los) Primary Keys solicitados

   * @todo mejorar IDs aun no esta en formato array
   * @todo si no existe registro retornar NULL?
   * @param array $ids Arreglo asociativo con los ids del registro a buscar
   * @param string $tabla Nombre d ela tabla
   * @param string $class Nombre d ela clase de los objetos que van a ser
   * @eturn mixed Un arreglo, objeto de tipo class o null si no encuentra registro
   */
  public function buscarXPK(array $ids, $tabla, $class=""){
    array_walk($ids, function(&$v, $k){
      $v = "$k='" . addslashes($v) . "'";
    });
    $where = implode(" AND ", $ids);
    $v = $this->buscar($tabla, $where, $class);
    return $v[0];
  }
  
  /**
   * buscar
   *
   * Busca un grupo de registros en una tabla de acuerdo a ciertos criterios
   *
   * @param string $tabla Nombre de la tabla donde buscar los datos
   * @param string $where Criterios de busqueda de la sentencia select en formato SQL
   * @param string $class Nombre de la clase con la que se generá las instancias de 
   *                     la salida, si es igual a vacio se retorna un arreglo de arreglos
   * @return array Un arreglo de objetos de tipo class o arrays, como resultado de buscar
   *         los registros en la tabla y criterios de indicados
   */
  abstract public function buscar($tabla, $where);

  /**
   * desc
   *
   * Busca la descripcción de las columnas de una tabla en una base de datos
   *
   * @param string $tabla Nombre d ela tabla a describir
   * @return array Un arreglo asociativo de Objetos de tipo Campos
   */
  abstract public function desc($tabla);

}
