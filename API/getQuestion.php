<?php
$dbHost = 'localhost';
$dbName = 'su-trivia';
$dbUsername = 'root';
$dbPassword = '';

$mysqli = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName); 

//get all rows
$result = mysqli_query($mysqli, "SELECT * FROM timer ORDER BY id DESC");

$json = getJsonDataDb($result);



$timeNowEpochs = getTimeEpochsNow();
$dateO = 'o';
$date = '';
$Question_Answers = getQuestion($json, $timeNowEpochs, $dateO, $date);
if($Question_Answers!="GameOver"){
  echo json_encode(array("Answer1" => $Question_Answers['Answer1'],
"Answer2" => $Question_Answers['Answer2'],"Answer3" => $Question_Answers['Answer3'],
"Answer4" => $Question_Answers['Answer4'],"Question" => $Question_Answers['question'],
"EndEpochs" => $dateO, "date" => $date));
}
else{
  echo '[{"GameOver": "GameOver"}]';
}




//push rows in json
function getJsonDataDb($result) {
  $rows = array();
  while($r = mysqli_fetch_assoc($result)) {
      $rows[] = $r;
  }
  return $rows;
}
//get time now
function getTimeEpochsNow(){
  $timeNow = file_get_contents("http://worldtimeapi.org/api/timezone/Africa/Cairo");
  $timeNowJson = json_decode($timeNow);
  $timeNowEpochs = $timeNowJson->unixtime;
  return $timeNowEpochs; 
}
function getQuestion($json, $timeNow,&$dateO, &$date) {
  
  foreach ($json as $element) {
    date_default_timezone_set('Africa/Cairo');
    $date = $element["date"];
    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);
    $startEpochs = mktime((int)$element["h"], (int)$element["m"], (int)$element["s"], (int)$month, (int)$day, (int)$year);
    //$startEpochs+=43200;
    $endEpochs = $startEpochs + 70;
    $dateO = $endEpochs;
    if($timeNow < $endEpochs && $timeNow >= $startEpochs){
      
      //return $element["question"];
      return $element;
    }
    
  } 
  return "GameOver";

}

?>
