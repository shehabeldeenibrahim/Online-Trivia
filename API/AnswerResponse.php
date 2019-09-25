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
if (isset($_GET['Answer']) && isset($_GET['id'])) {
    $Answer = $_GET['Answer'];
    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT CorrectAnswer FROM timer WHERE id='$id'");
    $data = mysqli_fetch_assoc($result);

    
    if($Answer == $data["CorrectAnswer"])
        echo json_encode(array("Response" => 'TRUE'));
    else
        echo json_encode(array("Response" => 'FALSE'));   

    //echo json_encode(array("Response" => $data));

}

$conn->close();
?>