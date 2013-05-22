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

<img src = "<?= "${GLOBALS['_URLIMGS']}/¨{$img->nombre}" ?>" />

<?php
  if($i%5==4) echo "<br />";
  ++$i;
endforeach;

$img = new Imagen(1);
print_r($img);
