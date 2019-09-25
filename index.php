<?php

//including the database connection file
$dbHost = 'localhost';
$dbName = 'su-trivia';
$dbUsername = 'root';
$dbPassword = '';

$mysqli = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName); 

$result = mysqli_query($mysqli, "SELECT * FROM timer ORDER BY id ASC");
while($res = mysqli_fetch_array($result)) { 
$date = $res['date'];
$h = $res['h'];
$m = $res['m'];
$s = $res['s'];
}
?>

<script src="Script.js"></script>

<style>
</style>

<html>

<head>
<link rel="stylesheet" type="text/css" href="Styles.css">
</head>

    <body>
        <div id="header"></div>
        <div id="questions"></div>
    </body>
</html>