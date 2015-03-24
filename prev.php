<?php  

$IdPrev = ($id-1);

IF($IdPrev > 0){ 

	echo "<a href='index.php?id=$IdPrev'> previous </a>";
	
}else{
	
	echo "<a href='index.php'> previous </a>";

}

 ?>
