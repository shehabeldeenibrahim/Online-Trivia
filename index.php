<?php
include_once('google/login.php');
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

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Style.css">
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Style.css">
</head>

    <body onload = "RenderAl()">
    <!--?php echo $output?-->
        <div class="container">
            <!-- Display login button / Google profile information -->
            <?php if ($Flag == 0): ?>
                <div id = 'C_alert' style ="display: none;"><p style="color:red">Please login through your AUC email account.</p>
                <br><br><center><?php echo $GoogleButton; ?></center></div>
                <div id = "overlay" style ="display:none;" onclick="CancelAlert()" ></div>
            <?php endif; ?>

            <?php if ($Flag == 1): ?>
                <!-- ?php echo $output; ? -->
                <div id="header"></div>
                <div id="answers"></div>
            <?php endif; ?>

        </div>
    </body>
</html>