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
if(isset($gpUserData))
    $oauthId = $gpUserData['oauth_uid'];
?>

<script type="text/javascript">var oauthId = "<?php echo $oauthId ?>";</script>
<script src="Script.js"> </script>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Buttons.css">
    <link rel="stylesheet" href="disco.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin&display=swap" rel="stylesheet">
</head>

    <body onload = "RenderAl()">
        <div class = 'Container'>
        <div id="progressBar">
            <div></div>
        </div>
            <!-- Display login button / Google profile information -->
            <?php if ($Flag == 0): ?>
                <div id = 'C_alert' style ="display: none;"><p style="color:red">Please login through your AUC email account.</p>
                <br><br><center><?php echo $GoogleButton; ?></center></div>
                <div id = "overlay" style ="display:none;" onclick="CancelAlert()" ></div>
            <?php endif; ?>

            <?php if ($Flag == 1): ?>
                <?php echo $output; ?>
                <center>
                <img style="margin-bottom:20px;" height="100" width="100" src="White SU Logo-02.png">
                <div id = 'Q_box'>
                <center>
                <div id="header"></div>
                <div id="answers"></div>
                </center>
                </div>
                </center>
            <?php endif; ?>

        </div>
    </body>
</html>