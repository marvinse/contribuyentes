<?php
//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$googleConfig = getGoogleConfig();
$clientId = $googleConfig["appId"];
$clientSecret = $googleConfig["appSecret"];
$redirectURL = 'http://localhost/proyecto/googleprofile.php';

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to Sistema Contribuyentes');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>