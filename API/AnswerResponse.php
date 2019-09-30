<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "su-trivia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//GET REQUEST
if (isset($_GET['Answer']) && isset($_GET['id'])) {
    $oauthId = $_GET["oauthId"];
    $Answer = $_GET['Answer'];
    $id = $_GET['id'];

    //compute epochs now
    $dateNow = new DateTime(null, new DateTimeZone('Africa/Cairo'));
    $timeNow = $dateNow->getTimestamp() + $dateNow->getOffset();
    $timeNow -=7200;

    //compute epochs of question time
    $result = mysqli_query($conn, "SELECT CorrectAnswer, h, m, s, date FROM timer WHERE id='$id'");
    $element = mysqli_fetch_assoc($result);
    $date = $element["date"];
    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);
    $startEpochs = mktime((int)$element["h"], (int)$element["m"], (int)$element["s"], (int)$month, (int)$day, (int)$year);
    $endEpochs = $startEpochs + 70;
    $dateO = $endEpochs;
    
    if($timeNow >= $endEpochs){ //if the question time is passed
        if($Answer == $element["CorrectAnswer"])
            echo json_encode(array("Response" => 'TRUE'));
        else{
            setSpectator($oauthId, $conn);
            echo json_encode(array("Response" => 'FALSE'));
        }
    } 
    else {
        echo json_encode(array("Response" => 'Cannot view answer now'));
    }

}

$conn->close();

function setSpectator($oauthId, $conn){
$sql  = "UPDATE users SET lost = '1' WHERE oauth_uid='$oauthId'";
$result = mysqli_query($conn, $sql);
}
?>