<?php

include 'conf/conf.php';
include 'core/ConnectorDB.php';
include 'core/ConnectorSQLite.php';

unlink('data/MyDB.bd');

$con = new ConnectorSqLite();
$sql = "CREATE TABLE images ( " .
"id integer PRIMARY KEY, " .
"name text NOT NULL)";
$con->run($sql);

for($i=0; $i<=9; ++$i){
  $sql = "INSERT INTO images(name) VALUES ('$i.png')"; 
  $con->run($sql);
}

