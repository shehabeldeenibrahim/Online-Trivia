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
    $gpUserData['correct_answers'] = !empty($gpUserProfile['correct_answers'])?$gpUserProfile['correct_answers']:'';

    
   $conn = mysqli_connect('localhost', 'root', '', 'su-trivia');
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $id_temp = $gpUserData['oauth_uid'];
    $sql  = "SELECT correct_answers FROM users WHERE oauth_uid='$id_temp'";
   
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
     try{
        $result = $data["correct_answers"];
        $data = $result;
    }
    catch(Exception $e) {
        echo $e->getMessage();
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
        // Insert or update user data to the database
        $gpUserData['oauth_provider'] = 'google';
        $userData = $user->checkUser($gpUserData);
        // Storing user data in the session
        $_SESSION['userData'] = $userData;


        // Render user profile data
        if(!empty($userData) && $userData!=0){
           /* $output  = '<h2>Google Account Details</h2>';
            $output .= '<div class="ac-data">';
            $output .= '<img src="'.$userData['picture'].'">';
            $output .= '<p><b>Google ID:</b> '.$userData['oauth_uid'].'</p>';
            $output .= '<p><b>Name:</b> '.$userData['first_name'].' '.$userData['last_name'].'</p>';
            $output .= '<p><b>Email:</b> '.$userData['email'].'</p>';
            $output .= '<p><b>Gender:</b> '.$userData['gender'].'</p>';
            $output .= '<p><b>Locale:</b> '.$userData['locale'].'</p>';
            $output .= '<p><b>Logged in with:</b> Google</p>';
            $output .= '<p><a href="'.$userData['link'].'" target="_blank">Click to visit Google+</a></p>';
            $output .= '<p>Logout from <a href="http://me.mydomain.com/timer_php//google//logout.php">Google</a></p>';
            $output .= '</div>';*/
            $output = '<img class = "user_img" src="'.$userData['picture'].'">';
            $output .= '<p>'.$userData['first_name'].' '.$userData['last_name'].'</p>';
            $output .= '<p><a href="http://me.mydomain.com/timer_php//google//logout.php">Logout</a></p><br><br>';
        }
        else{
            $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
        }
    }
}
else{
    
    // Get login url
    $authUrl = $gClient->createAuthUrl();
    
    // Render google login button
    $GoogleButton = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img width="200" height="50"src="google/images/google.png" alt=""/></a>';
    
}

?>