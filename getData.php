<?php
$mysqli = new MySQLi('localhost','kaptn','','my_kaptn');


if (mysqli_connect_errno()) {
    echo("Connect failed");
    exit();
}

$displayitems = 20;

$page = intval($_GET['page']);
$id = intval($_GET['id']);


if (intval($id) > 0) {

$resSet = $mysqli->query("select * from items Where id = ". $id );

}else{

$startindex = $page * $displayitems;
$resSet = $mysqli->query("select * from items order by date desc, time desc LIMIT 30 OFFSET ". $startindex );

}



$datePrev = "";

if($resSet->num_rows != 0){


	while($rows = $resSet->fetch_assoc())
	{
		$title = $rows['title'];
		$link = $rows['link'];
		$text = $rows['text'];
		$via = $rows['via'];
		$date = $rows['date'];
		
		$html = "";
		
		if ($date <> $datePrev) {
			
			$day = intval(substr($date,6,2));
			$month = intval(substr($date,4,2));
			$monthName = date("F", mktime(0, 0, 0, $month, 10));
			$year = intval(substr($date,0,4));
						
			echo "<div class='date' style='background-color:black;' >$monthName, $day</div>";
		}
						
						
		$html = "<div class='data'><p class='testo'><a class='titolo' href='$link'>$title</a> $text ";
		
		if ($via <> ""){
		$html .=  "<a class='via' href='$via'>>></a>";
		}
		
		
		$html .=  "</p></div>";
		echo ($html);
		
		$datePrev = $date;
		
		
	}

}else{
echo "<div class='data'>No Results</div>";
}

?>