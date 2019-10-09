var selectedAnswerNumber = 0;
var won =false;
function progress_circle(timeleft, timetotal){
    var forEach = function (array, callback, scope) {
        for (var i = 0; i < array.length; i++) {
            callback.call(scope, i, array[i]);
        }
    };
    
    var max = -219.99078369140625;
    forEach(document.querySelectorAll('.progress'), function (index, value) {
    percent = value.getAttribute('data-progress');
        percent = timeleft/timetotal*100;
        value.querySelector('.fill').setAttribute('style', 'stroke-dashoffset: ' + ((100 - percent) / 100) * max);
    });
    
}

function progress(timeleft, timetotal, $element) {
    var progressBarWidth = timeleft * $element.width() / timetotal;
    if(timeleft == 59){
        $element.find('div').animate({ width: progressBarWidth }, 500).html();
    }
    else{
    $element.find('div').animate({ width: progressBarWidth }, 0).html();}
    
};

function RenderAl(){
    document.getElementById("overlay").style.display = "block";
    var winW = window.innerWidth;
    document.getElementById("C_alert").style.display = "block";
    document.getElementById("C_alert").style.height = 300+"px";
    document.getElementById("C_alert").style.left = (winW/2) - (340 * .5)+"px";
    document.getElementById("C_alert").style.top = "100px"; 
    return (winW/2) - (340 * .5);
}

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
    // pass vars one,two,three,four by reference and choose class based on the variables

    if(num == '1'){
        var element = document.getElementById("two");
        element.classList.remove("Clicked");
        var element = document.getElementById("three");
        element.classList.remove("Clicked");
        var element = document.getElementById("four");
        element.classList.remove("Clicked");
        var element = document.getElementById("one");
        element.classList.add("Clicked");
    }
    else if(num == '2'){
        var element = document.getElementById("one");
        element.classList.remove("Clicked");
        var element = document.getElementById("three");
        element.classList.remove("Clicked");
        var element = document.getElementById("four");
        element.classList.remove("Clicked");
        var element = document.getElementById("two");
        element.classList.add("Clicked"); 
    }
    else if(num == '3'){
        var element = document.getElementById("one");
        element.classList.remove("Clicked");
        var element = document.getElementById("two");
        element.classList.remove("Clicked");
        var element = document.getElementById("four");
        element.classList.remove("Clicked");
        var element = document.getElementById("three");
        element.classList.add("Clicked");
    }
    else if(num == '4'){
        var element = document.getElementById("one");
        element.classList.remove("Clicked");
        var element = document.getElementById("two");
        element.classList.remove("Clicked");
        var element = document.getElementById("three");
        element.classList.remove("Clicked");
        var element = document.getElementById("four");
        element.classList.add("Clicked");
    }
    selectedAnswerNumber = num;
}

function SendAnswerResponse(answerNumber, id, oauthId, spectator){
    var theUrl = 'http://me.mydomain.com/timer_php//api//AnswerResponse.php' + '?Answer=' + answerNumber + '&id=' + id + '&oauthId=' + oauthId +'&spectator=' + spectator;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    value = JSON.parse(xmlHttp.responseText);
    return value.Response;
}

function main()
    {
        
    var showing =0;
    var question = getQuestionHttp("http://me.mydomain.com/timer_php//api//getQuestion.php" + '?oauthId=' + oauthId);
    var endTime = question.EndEpochs;
    var spectator = question.spectator;
    var time = httpGet('http://worldtimeapi.org/api/timezone/Africa/Cairo')
    var countDownDate = endTime * 1000;
    var prevq = question.Question;
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
    
    try{if(question[0].GameOver == 'GameOver' && !won){
        document.getElementById("header").innerHTML = 'BOBAWYYYYYYYY';
        document.getElementById("answers").innerHTML = 'BOBAWYYYYYYYY';
        return 0;
    }} catch {
        //
    }

    try{if(won){
        document.getElementById("header").innerHTML = 'WON';
        document.getElementById('answers').innerHTML = '<img id="spinner" height="250" width="250" src="cup.png">' ;
        return 0;
    }} catch {
        //
    }
    
    if(distance >15000 && distance <20000){
        //Buffer from 70th sec to 60th sec in this case
        document.getElementById("wrapper").style = 'display:none';
        document.getElementById("header").innerHTML = '<img class="logos" height="250" width="250" src="logos.png"><br><p style = "font-size:24px">Loading ...</p> ';
        document.getElementById("answers").innerHTML = "";
        showing = 0;
    }
 
    else{

        //progress(seconds, 60, $('#progressBar'));
        document.getElementById("wrapper").style = 'display:block';
        progress_circle(seconds, 15);
        
        var header_data = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s " + question.Question;
        document.getElementById("header").innerHTML = header_data;
        if(showing ==0){
            showing=1;
            document.getElementById("answers").innerHTML= 
            '<br><button class="bttn-dark corebttn" id ="one" onclick="HandleAnswer(1)">A:' + question.Answer1 
            + '</button><br><button class="bttn-dark corebttn" id ="two" onclick="HandleAnswer(2)">B:' + question.Answer2 +
            '</button><br><button class="bttn-dark corebttn" id ="three" onclick="HandleAnswer(3)">C:' + question.Answer3
            + '</button><br><button class="bttn-dark corebttn" id ="four" onclick="HandleAnswer(4)">D:' + question.Answer4 + '</button>';
            
                //if spectator grey out the answers
            if(spectator != question.id) {
                document.getElementById("one").disabled = true;
                document.getElementById("one").classList.remove("bttn-dark");
                document.getElementById("two").disabled = true;
                document.getElementById("two").classList.remove("bttn-dark");
                document.getElementById("three").disabled = true;
                document.getElementById("three").classList.remove("bttn-dark");
                document.getElementById("four").disabled = true;
                document.getElementById("four").classList.remove("bttn-dark");
            }
        }
        
    } 
    
    // If the count down is over, write some text 
    if (distance <= 0) {
        document.getElementById("header").innerHTML = prevq;
        //document.getElementById("header").innerHTML = question.question;
        clearInterval(x);
        // Need to handle if selectedAnswerNumber is 0
        var response = SendAnswerResponse(selectedAnswerNumber, question.id, oauthId, spectator);
        var answerElement = document.getElementsByClassName("Clicked");
        
        let numbersArray = ["null", "one", "two", "three", "four"];
        if(typeof answerElement[0] != 'undefined' && response =="TRUE"){
            var element = answerElement[0];
            element.classList.remove("bttn-dark");
            element.classList.remove("corebttn");
            element.classList.add("Right");

        }
        if(typeof answerElement[0] != 'undefined' && response.substr(0,5) == "FALSE"){
            var element = answerElement[0];
            element.classList.remove("bttn-dark");
            element.classList.add("Wrong");
            element.classList.remove("corebttn");
            var idIndex = numbersArray[parseInt(response[5])];
            document.getElementById(idIndex).classList.remove("bttn-dark");
            document.getElementById(idIndex).classList.remove("corebttn");
            document.getElementById(idIndex).classList.add("Right");
        }

        if(typeof answerElement[0] == 'undefined'  && response.substr(0,5) == "FALSE"){
            try {
                
                var idIndex = numbersArray[parseInt(response[5])];
                document.getElementById(idIndex).classList.remove("bttn-dark");
                document.getElementById(idIndex).classList.remove("corebttn");
                document.getElementById(idIndex).classList.add("Right");
            
            } catch (error) {
                console.log("error")
            }
            
            //After getting the correct answer number we should change it to class Right
        }
        if(typeof answerElement[0] == 'undefined'){
            try {
                var idIndex = numbersArray[parseInt(response[27])];
                document.getElementById(idIndex).classList.remove("bttn-dark");
                document.getElementById(idIndex).classList.remove("corebttn");
                document.getElementById(idIndex).classList.add("Right");
            
            } catch (error) {
                console.log("error")
            }
        }

        if(spectator == "3" && question.id == "3") {
            if(response == "TRUE")
                document.getElementById('header').innerHTML = "WON";
                document.getElementById('answers').innerHTML = '<img id="spinner" height="150" width="150" src="cup.png">' ;
                won = true;
        }

        setTimeout(function() {
            //your code to be executed after 1 second
            main();
          }, 1800);
        
    }
        
    }, 1000);
    return question;
}
    var apiResponse;
    apiResponse = main();
