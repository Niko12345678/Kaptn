<?php
$servername = "localhost";
$username = "kaptn";
$password = "";
$dbname = "my_kaptn";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//$insert_row = $mysqli->query("INSERT INTO items (title,text,link,date,time) values('" . $title . "' ,'" . $text . "','" . $link . "','" . $date . "','" . $time . "')");
	$stmt = $conn->prepare("INSERT INTO items (title,text,link,via,date,time) values(?, ?, ?, ?, ?, ?)");
	//$stmt->bind_param("ssssss", $title, $text, $link, $via, $date, $time );

	$title = htmlspecialchars($_POST["title"]);
	$text = htmlspecialchars($_POST["text"]);
	$link = htmlspecialchars($_POST["link"]);
	$via = htmlspecialchars($_POST["via"]);
	$date = htmlspecialchars($_POST["date"]);
	$time = htmlspecialchars($_POST["time"]);

	$data = array($title, $text, $link, $via, $date, $time );
	
	$stmt->execute($data);

    echo "New records created successfully";
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;



?>