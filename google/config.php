<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'su-trivia');
define('DB_USER_TBL', 'users');

// Google API configuration
define('GOOGLE_CLIENT_ID', '495456339537-tv8u099a7g89e5rmjj96gu4ds51emu8p.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '9RfWsy_U1L2VhgSowztFvk5K');
define('GOOGLE_REDIRECT_URL', 'http://me.mydomain.com/timer_php//google//login.php');

// Start session 
if(!session_id()){
    session_start();
}

// Include Google API client library
require_once 'newnew/google-api-php-client/src/Google_Client.php';

require_once 'newnew/google-api-php-client/src/contrib/Google_Oauth2Service.php';

// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('su-trivia');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_oauthV2 = new Google_Oauth2Service($gClient);