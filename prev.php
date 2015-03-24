<?php  

$IdPrev = ($page-1);

IF($IdPrev > 0){ 

	echo "<a href='index.php?page=$IdPrev'> previous </a>";
	
}else{
	
	echo "<a href='index.php'> previous </a>";

}

 ?>
