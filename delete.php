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
if (isset($_GET['id'])) {
    $id = $_GET['id'];

// sql to delete a record
$sql = "DELETE FROM timer WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
}

$conn->close();
?>