<style>
  img{
    width:150px;
    height:200px;
  }
</style>

<?php
$i=0;
foreach($imagenes as $img):
?>

<img src = "<?= "{$GLOBALS['_URLIMGS']}/{$img->nombre}" ?>" />

<?php
  if($i%5==4) echo "<br />";
  ++$i;
endforeach;

$img = new Imagen(1);
print_r($img);

echo "<br>";
echo "<br>";

foreach(Imagen::$DATOSTABLA["CAMPOS"] as $k => $campo){
  echo "$k: ";
  print_r($campo);
  echo "<br>";
}

echo "<br>";
print_r(Imagen::$DATOSTABLA['PKS']);
echo "<br>";
print_r(Imagen::$DATOSTABLA['OBLIGATORIOS']);

echo "<br>";
echo "<br>";
$img = new Imagen(array(
  "nombre"=>"Nuevo.png"
));
print_r($img);

