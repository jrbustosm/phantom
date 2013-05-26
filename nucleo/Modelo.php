<?php

/**
 * Modelo
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @link https://github.com/jrbustosm/phantom/blob/master/nucleo/Modelo.php
 * @license GPL version 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 * 
*/

/**
 * Clase Modelo
 * 
 * Es la representación de una tabla de una base de datos en un modelo POO
 *
 * @property ConectorBD $con Manejador de Base de Datos
 * @property array $datos Datos del registro
 * @property array $mapFuncTipo arraglo que mapea los tipos de datos con la
 *           función que va a evaluar los datos de este tipo
 *
 * @author Jose Ricardo Bustos Molina <jrbustosm@gmail.com>
 * @version $Id$
 * @package nucleo
 * @since 0.1
 * @see ConectorBD
 */
abstract class Modelo{

  private static $con; //Manejador de base de datos
  private $datos;      //Datos almacenados en el registro

  private static $mapFuncTipo = array(
    "int" => "is_int",
    "integer" => "is_int",
  );

  /**
   * Constructor
   *
   * __construct($id1, [$id2, ... , $idn])
   * __construct(array $datos)
   *
   * @param string $ids Identificadores del registro
   * @param array $datos Arreglo asociativo con los datos del registro
   * @todo generar una excepcion si los datos del array no concuerdan con las columnas de la tabla (obligatorios)
   * @todo mejorar el constructor usando diff con los campos de la tabla
   */
  function __construct(){
    if(func_num_args()==1 && is_array(func_get_arg(0))){
      $arg = func_get_arg(0);
      //TODO: falta verificar
      $this->datos = $arg;
    }else if(func_num_args()>0){
      //Buscar los datos dado los ids
      if(count($this::$DATOSTABLA['PKS']) != func_num_args())
        throw new Exception('Numero de argumentos erroneos');
      $ids = array_combine($this::$DATOSTABLA['PKS'], func_get_args());
      //Verificar los tipos de os IDs
      foreach($ids as $pk => $id){
        $tipo = $this::$DATOSTABLA['CAMPOS'][$pk]->tipo;
        if(!self::verificarTipo($id, $tipo)){
          throw new Exception('Tipo de argumento invalido');
        }
      }
      $this->datos = self::$con->buscarXPK($ids, $this::$DATOSTABLA['NOMBRETABLA']);
    }else{
      throw new Exception('Se necesitan argumentos para crear un Modelo');
    }
  }
  
  /**
   * Método para consultar propiedades del modelo
   *
   * @param string $propiedad Propiedad a consultar
   * @return mixed Valor de la propiedad solicitada, si la propiedad existe pero no esta definida retorna NULL
   */
  public function __get($propiedad){
    if(!in_array($propiedad, array_keys($this::$DATOSTABLA['CAMPOS'])))
      throw new Exception('Propiedad inexistente');
    if(isset($this->datos[$propiedad])) return $this->datos[$propiedad];
    return NULL;
  }

  /**
   * Método que inicializa los atributos de clase
   */
  public static function static_init(){
    //Se selecciona el conector seleccionado en la configuración
    $conclass = "Conector" . $GLOBALS['_BDMOTOR'];
    self::$con = new $conclass();
  }
  
  /**
   * Método que iniciliza la descripción del esquema de la tabla
   */
  public static function cargarDesc(){
    $class = get_called_class();
    $class::$DATOSTABLA['CAMPOS'] = self::$con->desc(static::$DATOSTABLA['NOMBRETABLA']);
    $class::$DATOSTABLA['PKS'] = array_keys(
      array_filter($class::$DATOSTABLA['CAMPOS'], function($c){
        return $c->pk;
      })
    );
    $class::$DATOSTABLA['OBLIGATORIOS'] = array_keys(
      array_filter($class::$DATOSTABLA['CAMPOS'], function($c){
        return $c->noNulo;
      })
    );
  }

  /**
   * Método que retorna todos los registros de una tabla de una base de datos
   *
   * @return array Arreglo de con todos los objetos de tipo modelo que se encuentra en la tabla
   */
  public static function buscarTodos(){
    return self::$con->buscarTodos(static::$DATOSTABLA['NOMBRETABLA'], get_called_class());
  }

  /**
   * verificarTipo
   *
   * Verifica si el tipo de un dato coincide con el tipo solicitado
   *
   * @todo Que pasa si el tipo es desconocido? un warning? un error? nada?
   * @param mixed $valor Dato a comprobar su tipo
   * @param string $tipo Tipo a verificar
   * @return bool Verdadero si el dato coincide con el tipo solicitado
   */
  private static function verificarTipo($valor, $tipo){
    $func = self::$mapFuncTipo[$tipo];
    return $func($valor);
  }

}

