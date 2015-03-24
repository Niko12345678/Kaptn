<?php
$mysqli = new MySQLi('localhost','kaptn','','my_kaptn');


if (mysqli_connect_errno()) {
    echo("Connect failed");
    exit();
}

$id = 0;

if(empty($_GET['id'])){
$resSet = $mysqli->query("select * from items order by date desc, time desc ");
}else{
$id=intval($_GET['id']);
$resSet = $mysqli->query("select * from items where id =" . $id . " order by date desc, time desc");
}

$datePrev = "";

if($resSet->num_rows != 0){


	while($rows = $resSet->fetch_assoc())
	{
		$title = $rows['title'];
		$link = $rows['link'];
		$text = $rows['text'];
		$date = $rows['date'];
		
		if ($date <> $datePrev) {
			
			$day = intval(substr($date,6,2));
			$month = intval(substr($date,4,2));
			$year = intval(substr($date,0,4));
						
			echo "<div class='date'> $day - $month - $year</div>";
		}
						
		echo "<div class='data'><p class='testo'><a class='titolo' href='$link'>$title</a> $text</p></div>";
			
		$datePrev = $date;
		
		
	}

}else{
echo "<div class='data'>No Results</div>";
}

?>