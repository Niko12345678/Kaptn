<?php  

$IdPrev = ($page-1);

IF($IdPrev > 0){ 

	echo "<a class='prev' href='index.php?page=$IdPrev'> previous </a>";
	
}else{
	
	echo "<a class='prev' href='index.php'> previous </a>";

}

 ?>
