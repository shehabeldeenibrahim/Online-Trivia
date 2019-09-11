<?php
include("config.php");

//get all rows
$result = mysqli_query($mysqli, "SELECT * FROM timer ORDER BY id DESC");

$json = getJsonDataDb($result);

$timeNowEpochs = getTimeEpochsNow();
$dateO = 'o';
$date = '';
$question = getQuestion($json, $timeNowEpochs, $dateO, $date);

echo json_encode(array("Question" => $question,"EndEpochs" => $dateO, "date" => $date));




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
    $endEpochs = $startEpochs + 60;
    $dateO = $endEpochs;
    if($timeNow < $endEpochs && $timeNow >= $startEpochs){
      
      return $element["question"];
    }
    
  } 
  return "GameOver";

}

?>
