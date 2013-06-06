<style>
  img{
    width:150px;
    height:200px;
  }
</style>

<?php
$i=0;
foreach($images as $img):
?>

<img src = "<?= "{$GLOBALS['_URLIMGS']}/{$img->name}" ?>" />

<?php
  if($i%5==4) echo "<br />";
  ++$i;
endforeach;

echo "<br>";
$img = new Image(array(
  "id"=>1,
  "name"=>"0.png"
));
print_r($img);
//$img->save()

