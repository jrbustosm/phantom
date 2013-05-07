<?
  class conectorSQLite extends ConectorBD{
		function __construct(){
			parent::__construct();
		}
		function __destruct(){
			parent::__destruct();
		}
		public function abrir(){
			$this->manejador=sqlite_open("datos/mi.bd");
		}
		public function cerrar(){
			sqlite_close($this->manejador);
		}
		public function ejecutar($sql){
			return sqlite_exec($this->manejador, $sql);
		}
		
	
	}
