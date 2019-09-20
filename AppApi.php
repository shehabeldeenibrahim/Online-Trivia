<?php
$date = new DateTime('2001-01-01');

$date -> setTime(14,55);

echo json_encode(array("date" => $date -> format('Y-m-d H:i:s')));

?>
