<?php
  for($i=0; $i<count($imagenes); ++$i){
		$nombre = $imagenes[$i]['nombre'];
?>
<img src = "../img/<?= $nombre?>" style="width:150px; height:200px;"/>
<?php
    if($i%5==4) echo "<br />";
	}
?>
		
