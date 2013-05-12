<?php

  include '../nucleo/ConectorBasedeDatos.php';
  include '../nucleo/ConectorSQLite.php';
		
  $con = new ConectorSqLite();
  $sql = "CREATE TABLE imagenes ( " .
         "id integer PRIMARY KEY, " .
         "nombre text NOT NULL)";
  $con->ejecutar($sql);

  for($i=0; $i<=9; ++$i){
    $sql = "INSERT INTO imagenes(nombre) VALUES ('$i.png')"; 
    $con->ececutar($sql);
  }
	
