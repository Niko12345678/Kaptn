<?php

$title = htmlspecialchars($_POST["title"]);
$text = htmlspecialchars($_POST["text"]);
$link = htmlspecialchars($_POST["link"]);
$date = htmlspecialchars($_POST["date"]);
$time = htmlspecialchars($_POST["time"]);


$mysqli = new MySQLi('localhost','kaptn','','my_kaptn');

if (mysqli_connect_errno()) {
    echo("Connect failed");
    exit();
};

$insert_row = $mysqli->query("INSERT INTO items (title,text,link,date,time) values('" . $title . "' ,'" . $text . "','" . $link . "','" . $date . "','" . $time . "')");

if($insert_row){
    print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
}else{
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}



?>