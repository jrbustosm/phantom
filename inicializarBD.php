<?php

include 'nucleo/ConectorBD.php';
include 'nucleo/ConectorSQLite.php';

unlink('datos/mi.bd');

$con = new ConectorSqLite();
$sql = "CREATE TABLE imagenes ( " .
"id integer PRIMARY KEY, " .
"nombre text NOT NULL)";
$con->ejecutar($sql);

for($i=0; $i<=9; ++$i){
  $sql = "INSERT INTO imagenes(nombre) VALUES ('$i.png')"; 
  $con->ejecutar($sql);
}

