<style>
  img{
    width:150px;
    height:200px;
  }
</style>

<?php
//TODO: esto se debe cambiar por un foreach que itere sobre objetos y no sobre un arreglo de datos
for($i=0; $i<count($imagenes); ++$i):
  $nombre = $imagenes[$i]['nombre'];
?>

<img src = "<?= "${GLOBALS['_URLIMGS']}/$nombre" ?>" />

<?php
  if($i%5==4) echo "<br />";
endfor;

$img = new Imagen(1);
print_r($img);
