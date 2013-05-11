<?php
  for($i=0; $i<count($imagenes); ++$i){
		$nombre = $imagenes[$i]['nombre'];
		echo $nombre;
?>
<img src = "../img/<?= $nombre?>"/>
<?php
	}
?>
		
