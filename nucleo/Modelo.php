<?php
     abstract class Modelo{
         private static $con;
         private static $nombre;
  	 
	     public function__construct(){
		     $this -> con = new ConectorSQLite();
			 $this -> nombre = $nombre;
		 }
		 public static function buscarTodos(){
		     return $this -> con ->buscarTodos($nombre);
		 }
}
