<?php

  include 'nucleo/ConectorBasedeDatos.php';
  include 'nucleo/ConectorSQLite.php';
		
  $con = new ConectorSqLite();
  $sql = "CREATE TABLE Imagenes ( " .
         "id PRIMARY KEY, " .
         "nombre text NOT NULL)";
  $con->ejecutar($sql);
	
