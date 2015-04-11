<?php

require_once 'percorso/relativo/class.Strings.php';
require_once 'percorso/relativo/class.Feed.php';
require_once 'percorso/relativo/class.FeedEntry.php';

$feed_title   = "KAPTN";
$feed_link    = "http://kaptn.altervista.org/feed.xml";
$description  = "";
$website_link = "http://kaptn.altervista.org/";



$feed = new Feed($feed_title, $feed_link, $description, $website_link);

$mysqli = new MySQLi('localhost','kaptn','','my_kaptn');


if (mysqli_connect_errno()) {
    exit();
}

$resSet = $mysqli->query("select * from items order by date desc, time desc LIMIT 30" );
if($resSet->num_rows != 0){

	while($rows = $resSet->fetch_assoc())
	{
	$title = $rows['title'];
	$link = $rows['link'];
	$text = $rows['text'];
	$via = $rows['via'];
	$date = $rows['date'];
	$id = $rows['id'];

	$day = intval(substr($date,6,2));
	$month = intval(substr($date,4,2));
	$year = intval(substr($date,0,4));

	$date = new DateTime($year . '-' . $month . '-' . $day);

	$feedEntry = new FeedEntry($title);
	$feedEntry->link = "http://kaptn.altervista.org/index.php?id=" . intval($id);
	$feedEntry->pubDate = $date->format('D, j M Y H:i:s O');
	$feedEntry->content = "<p class='testo'><a class='titolo' href='$link'>$title</a> $text</p> "
	$feed->addEntry($feedEntry);
	}
}
$feed->output();


?>