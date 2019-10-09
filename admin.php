<html>
    <form method="POST">
    hour1:<br>
    <input type="text" name="hour1"><br>
    minute1:<br>
    <input type="text" name="minute1"><br>

    hour2:<br>
    <input type="text" name="hour2"><br>
    minute2:<br>
    <input type="text" name="minute2"><br>

    hour3:<br>
    <input type="text" name="hour3"><br>
    minute3:<br>
    <input type="text" name="minute3"><br>
    <input type="submit" name="submit" value="submit"><br>
    </form>
</html>
<?php 
$servername = "localhost";
$username = 'root';
$password = "";
$dbname = "su-trivia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


if(isset($_POST["submit"])){
    $hour1 = $_POST["hour1"];
    $minute1 = $_POST["minute1"];
    $hour2 = $_POST["hour2"];
    $minute2 = $_POST["minute2"];
    $hour3 = $_POST["hour3"];
    $minute3 = $_POST["minute3"];
    $sql  = "UPDATE timer SET h = '$hour1', m = '$minute1' WHERE id = '1';UPDATE timer SET h = '$hour2', m = '$minute2' WHERE id = '2'; UPDATE timer SET h = '$hour3', m = '$minute3' WHERE id = '3';";
    $result = mysqli_multi_query($conn, $sql);
echo $result;

}

?>