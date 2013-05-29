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

echo "<br>";
$img = new Imagen(array(
  "id"=>1,
  "nombre"=>"0.png"
));
print_r($img);
//$img->guardar()

