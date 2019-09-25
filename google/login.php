<?php
// Include configuration file
require_once 'config.php';

// Include User library file
require_once 'User.class.php';
$Flag =0;
$Played = 0;
if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
}

if(isset($_SESSION['token'])){
    $gClient->setAccessToken($_SESSION['token']);
}

if($gClient->getAccessToken()){
    // Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();
    
    // Initialize User class
    $user = new User();
    
    // Getting user profile info
    $gpUserData = array();
    $gpUserData['email']      = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
    $gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
    $gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
    $gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
    $gpUserData['gender']     = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
    $gpUserData['locale']     = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
    $gpUserData['picture']    = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
    $gpUserData['link']       = !empty($gpUserProfile['link'])?$gpUserProfile['link']:'';
    
   $conn = mysqli_connect('localhost', 'root', '', 'su-trivia');
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $id_temp = $gpUserData['oauth_uid'];
    $sql  = "SELECT prize FROM users WHERE oauth_uid='$id_temp'";
   
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
     try{
        $result = $data["prize"];
        $data = $result;
    }
    catch(Exception $e) {
        echo $e->getMessage();
    }
if(isset($_POST['prize'])) {
    //update db to put prize value in
    
    $cookie = $_POST['prize'];
    $id = $gpUserData['oauth_uid'];
    $updateQuery = "UPDATE users SET prize= '$cookie' WHERE oauth_uid='$id'";
    mysqli_query($conn, $updateQuery);
    
   // file is opened using fopen() function 
    $my_file = fopen("file.txt", "r"); 
      
    // Prints a single line from the opened file pointer 
    
    $cookie_ = $_POST['prize'];
    $msg = '';
    
    $st = fgets($my_file); 
    echo $st;
    fclose($my_file); 
    $my_file = fopen("file.txt", "w");
    $json = json_decode($st);
    $temp = $json-> $cookie_;
    $temp = (int)$temp + 1;
    $json-> $cookie_ = $temp;
    //echo $json->one;
    //echo $json->two;
    //echo $json->three;
    //echo $json->four;
    //echo $json->five;
    //echo $json->six;
    $json_string = json_encode($json);
    file_put_contents("file.txt", "");
    fwrite($my_file, $json_string);
    // file is closed using fclose() function 
    fclose($my_file); 
    
    //unset($_COOKIE['won']);
    // empty value and expiration one hour before
    //$res = setcookie('won', '', time() - 3600);

    unset($_POST['prize']);
    }

    
        if(substr($gpUserData['email'], -12) != 'aucegypt.edu'){
        // Remove token and user data from the session
        unset($_SESSION['token']);
        unset($_SESSION['userData']);
        // Reset OAuth access token
        $gClient->revokeToken();
        // Destroy entire session data
        session_destroy();
        $output = '<h3 style="color:red">Please login through your AUC email account.</h3>';
        $Flag =0;
        }
        else{

        $Flag =1;
        
        if($data =="one"||$data =="two"||$data =="three"||$data =="four"||$data =="five"||$data =="six"){
            $Played = 1;
            if($data == "one"){
                $msg = "<br><center><h1 style =' font-weight: 900;font-size: large;color:#AFF9AC;'>Congratulations you won a voucher of 500 LE courtesy of the SU Card #FundToServe <br> Sign Up through here the SU app </h1></center>";
                
                
            }
            else if($data == "two"){
                $msg = "<br><br><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you either won an airpod or a JBL speaker. Come by our booth to find out</h1>";
            }
            
            else if($data == "three"){
                $msg = "<br><br><h1 style =' font-weight: 900;font-size: large;color: red;'>I'm sorry but you did not win anything. :) </h1><center><img src ='khaled.jpg' width='200' height ='150' style ='margin-left:0px;'></img></center>";
            }
            
            else if($data == "four"){
                $msg = "<br><br><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you won a voucher of 25 LE from the SU Market/ SU Culturl Hub ! </h1>";
            }
            
            else if($data == "five"){
                $msg = "<br><br><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you won a voucher from L'aroma for a free Latte/Cappuccino !</h1>";
            }
            
            else if($data == "six"){
                $msg = "<br><br><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you won a  voucher to print 50 A4 papers from the Cultural Hub !</h1>";
            }
            
            
            
            
        }
    // Insert or update user data to the database
    $gpUserData['oauth_provider'] = 'google';
    $userData = $user->checkUser($gpUserData);
        // Storing user data in the session
    $_SESSION['userData'] = $userData;

    

    
    // Render user profile data
    if(!empty($userData) && $userData!=0){
        $output  = '<h2>Google Account Details</h2>';
        $output .= '<div class="ac-data">';
        $output .= '<img src="'.$userData['picture'].'">';
        $output .= '<p><b>Google ID:</b> '.$userData['oauth_uid'].'</p>';
        $output .= '<p><b>Name:</b> '.$userData['first_name'].' '.$userData['last_name'].'</p>';
        $output .= '<p><b>Email:</b> '.$userData['email'].'</p>';
        $output .= '<p><b>Gender:</b> '.$userData['gender'].'</p>';
        $output .= '<p><b>Locale:</b> '.$userData['locale'].'</p>';
        $output .= '<p><b>Logged in with:</b> Google</p>';
        $output .= '<p><a href="'.$userData['link'].'" target="_blank">Click to visit Google+</a></p>';
        $output .= '<p>Logout from <a href="logout.php">Google</a></p>';
        $output .= '</div>';
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
            
        }
}
else{
    
    // Get login url
    $authUrl = $gClient->createAuthUrl();
    
    // Render google login button
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img width="200" height="50"src="images/google.png" alt=""/></a>';
    
}

?>


<html>
  <head>
      <title>SPIN THE WHEEL!</title>
     <link rel="shortcut icon" href="icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" media="screen" type="text/css" />
  
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css'>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

  </head>
  <body>
  <?php echo $output; ?>
  </body>
  
<script>
       function RenderAl(){
          document.getElementById("overlay").style.display = "block";
          var winW = window.innerWidth;
          document.getElementById("C_alert").style.display = "block";
          document.getElementById("C_alert").style.height = 300+"px";
          document.getElementById("C_alert").style.left = (winW/2) - (340 * .5)+"px";
          document.getElementById("C_alert").style.top = "100px"; }
          
          //set default degree (360*5)
  var degree = 1800;
  //number of clicks = 0
  var clicks = 0;
  
  $(document).ready(function(){
      
      /*WHEEL SPIN FUNCTION*/
      $('#spin').click(function(){
          
          //add 1 every click
          clicks ++;
          
          /*multiply the degree by number of clicks
        generate random number between 1 - 360, 
      then add to the new degree*/
          var newDegree = degree;
          var extraDegree;// = 280;
          if(clicks<=1){
          extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
          }
          
          var p1; var p2; var p3; var p4; var p5; var p6;
          
      	var rawFile = new XMLHttpRequest();
    rawFile.open("GET", "file.txt", false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status === 0)
            {
                //assuming file.txt : 256478 where 2 is the number of prize#1 given and 5 the number of prize#2 given.....
                var allText = rawFile.responseText;
                allText = JSON.parse(allText);
                
                p1 = allText.one;
                p2 = allText.two;
                p3 = allText.three;
                p4 = allText.four;
                p5 = allText.five;
                p6 = allText.six;
                
            }
        }
    }
    rawFile.send(null);
            console.log(extraDegree);
            var ggflag = p1>=12 && p2>=12 && p3>=300 && p4>=300 && p5>=252 && p6>=300;
           // console.log(ggflag);
           // if(ggflag == true){
          //      console.log(ggflag);
           //     document.body.innerHTML = "<p><br>Thank you!</p>";
          //      window.location = 'about:blank';
          //  }
            
      // If giveaway type passed maximum amount
          do{
             // extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
              console.log(extraDegree);
              if(extraDegree>330 && extraDegree<=360 || extraDegree>0 && extraDegree<=30){
                if(p1>=12){ //assuming 5 is the maximum number of prize1's that could be given
                    extraDegree = Math.floor(Math.random() * (330 - 1 + 1)) + 31;
                }
                var rand = Math.random();
                console.log(rand);
                if(rand>=0.075){
                    p1=20;
                    extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                    
                }
              }
              else if(extraDegree>30 && extraDegree<=90){
                if(p2>=12){ //assuming 5 is the maximum number of prize1's that could be given
                     do {
                            extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                        }while ((extraDegree>30 && extraDegree<=90))
                }
                var rand = Math.random();
                console.log(rand);
                if(rand>=0.075){
                    p2=20;
                    extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                    
                }
              }

              else if(extraDegree>90 && extraDegree<=150){
                if(p3>=300){ //assuming 5 is the maximum number of prize1's that could be given
                    do {
                            extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                        }while ((extraDegree>90 && extraDegree<=150)) 
                }
              }
                 else if(extraDegree>150 && extraDegree<=210){
                    if(p4>=300){ //assuming 5 is the maximum number of prize1's that could be given
                    do{
                            extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                        }while ((extraDegree>150 && extraDegree<=210)) 
                }
              }

              else if(extraDegree>210 && extraDegree<=270){
                  if(p5>=252){ //assuming 5 is the maximum number of prize1's that could be given
                     do {
                            extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                        }while ((extraDegree>210 && extraDegree<=270))
                }
              }
              else if(extraDegree>270 && extraDegree<=330){
                if(p6>=300){ //assuming 5 is the maximum number of prize1's that could be given
                    do {
                          extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                        } while ((extraDegree>270 && extraDegree<=330))
                }
              }
              
              var wflag = (p1>=12 &&(extraDegree>330 && extraDegree<=360 || extraDegree>0 && extraDegree<=30)) || (extraDegree>30 && extraDegree<=90 && p2>=18) || (extraDegree>90 && extraDegree<=150 && p3>=300) || (extraDegree>150 && extraDegree<=210 && p4>=300) ||(extraDegree>210 && extraDegree<=270&& p5>=252)|| (extraDegree>270 && extraDegree<=330 && p6>=300);
      }while(wflag)
          console.log(extraDegree);
          
          totalDegree = newDegree+extraDegree;
          
          /*let's make the spin btn to tilt every
          time the edge of the section hits 
          the indicator*/
          $('#wheel .sec').each(function(){
              var t = $(this);
              var noY = 0;
              
              var c = 0;
              var n = 700;	
              var interval = setInterval(function () {
                  c++;				
                  if (c === n) { 
                      clearInterval(interval);				
                  }	
                      
                  var aoY = t.offset().top;
                  
                  
                  /*23.7 is the minumum offset number that 
                  each section can get, in a 30 angle degree.
                  So, if the offset reaches 23.7, then we know
                  that it has a 30 degree angle and therefore, 
                  exactly aligned with the spin btn*/
                  if(aoY < 23.89){
                      console.log('<<<<<<<<');
                      $('#spin').addClass('spin');
                      setTimeout(function () { 
                          $('#spin').removeClass('spin');
                      }, 100);	
                  }
              }, 10);
              
              $('#inner-wheel').css({
                  'transform' : 'rotate(' + totalDegree + 'deg)'			
              });
              
              
              noY = t.offset().top;
              var prize_;
			
			if(extraDegree>330 && extraDegree<=360 || extraDegree>0 && extraDegree<=30){
			  prize_ = "one";  
			  setTimeout(function(){ $("#prize").html("<br><center><h1 style =' font-weight: 900;font-size: large;color:#AFF9AC;'>Congratulations you won a voucher of 500 LE courtesy of the SU Card #FundToServe <br> Sign Up through here the SU app </h1></center>"); }, 4000);
			}
			else if(extraDegree>30 && extraDegree<=90){
                  prize_ = "two";
			    setTimeout(function(){ $("#prize").html("<br><center><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you either won an airpod or a JBL speaker. Come by our booth to find out</h1></center>"); }, 4000);
			}
			else if(extraDegree>90 && extraDegree<=150){
			      prize_ = "three";
			    setTimeout(function(){ $("#prize").html("<br><center><h1 style =' font-weight: 900;font-size: large;color: red;'>I'm sorry but you did not win anything. :) </h1><img src ='khaled.jpg' width='300' height ='230'></img><center>"); }, 4000);
			}
		   	else if(extraDegree>150 && extraDegree<=210){
			     prize_ = "four";
			    setTimeout(function(){ $("#prize").html("<br><center><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you won a voucher of 25 LE from the SU Market/ SU Culturl Hub ! </h1></center>"); }, 4000);
			}
			else if(extraDegree>210 && extraDegree<=270){
			      prize_ = "five";
			    setTimeout(function(){ $("#prize").html("<br><center><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you won a voucher from L'aroma for a free Latte/Cappuccino !</h1></center>"); }, 4000);
			}
			else if(extraDegree>270 && extraDegree<=330){
			      prize_ = "six";
			    setTimeout(function(){ $("#prize").html("<br><center><h1 style =' font-weight: 900;font-size: large;color: red;'>Congratulations you won a  voucher to print 50 A4 papers from the Cultural Hub !</h1></center>"); }, 4000);
			}
			$.ajax({
                url: 'index.php',
                type: 'post',
                data: {prize: prize_},
                success: function(response){
                    //do whatever.
                }
                });              
              
          });
      });
      
      
      
  });//DOCUMENT READY
      
  
  
</script>
  

<body onload = "RenderAl()"  > 
<div class="container">
    <!-- Display login button / Google profile information -->
    <?php if ($Flag == 0): ?>
    <div id = 'C_alert' style ="display: none;"><p style="color:red">Please login through your AUC email account.</p><?php echo $output; ?></div>
    <div id = "overlay" style ="display:none;" onclick="CancelAlert()" ></div>
    <?php endif; ?>
    
    <?php if ($Played == 1): ?>
    <div id = 'C_alert' style ="display: none;"><p style="color:red">You have already played. <?php echo $msg; ?></p></div>
    <div id = "overlay" style ="display:none;" onclick="CancelAlert()" ></div>
    <?php endif; ?>
    
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


</body>
</html>