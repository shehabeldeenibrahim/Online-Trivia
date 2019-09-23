<?php

//including the database connection file
include("config.php");

$result = mysqli_query($mysqli, "SELECT * FROM timer ORDER BY id ASC");
while($res = mysqli_fetch_array($result)) { 
$date = $res['date'];
$h = $res['h'];
$m = $res['m'];
$s = $res['s'];
}
?>
<script>
function httpGet(theUrl)
{
    
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    time1 = JSON.parse(xmlHttp.responseText);
    var time = time1.datetime;
    index = time.indexOf("T")
    index1 = time.indexOf(".")
    //time = time.substr(index+1, index1-index-1);
    time = time.substr(0, index1);
    
    time = new Date(time);
    return time;
}
function getQuestionHttp(theUrl){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    question = JSON.parse(xmlHttp.responseText);
    return question
}

function HandleAnswer(num){
    
}

function main()
    {
    var question = getQuestionHttp("http://localhost/trivia/getQuestion.php");
    var endTime = question.EndEpochs;

    var time = httpGet('http://worldtimeapi.org/api/timezone/Africa/Cairo')
    var countDownDate = endTime * 1000;

    var now = time * 1000;
    now /= 1000

    // Update the count down every 1 second
    var x = setInterval(function() {
    now = now + 1000;

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Output the result in an element with id="demo"

    if(distance >60000 && distance <70000){
        //Buffer from 70th sec to 50th sec in this case
        document.getElementById("demo").innerHTML = "buffer";
    }
    else{
    document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
    minutes + "m " + seconds + "s " + question.Question +
    '<br><button onclick="HandleAnswer(1)">A:' + question.Answer1 
    + '</button><br><button onclick="HandleAnswer(2)">B:' + question.Answer2 +
    '</button><br><button onclick="HandleAnswer(3)">C:' + question.Answer3
    + '</button><br><button onclick="HandleAnswer(4)">D:' + question.Answer4 + '</button>';
    }
    
    // If the count down is over, write some text 
    if (distance < 0) {
        document.getElementById("demo").innerHTML = "Please wait for the next question";
        clearInterval(x);
        //  document.getElementById("demo").innerHTML = "EXPIRED";
        main();
    }
        
    }, 1000);
    return question;
}
    var apiResponse;
    apiResponse = main();
    </script>
<html>
    <body id="demo">
    </body>
</html>