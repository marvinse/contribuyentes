<?php
session_start();
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}
include 'functions.php';
require_once 'fbConfig.php';
require_once 'Facebook.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Sistema contribuyentes</title>
		<link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/styles.css" />
	</head>
	<body>
		<nav>
			<h1>Sistema de contribuyentes</h1>
			<ul>
				<li><a href="admin.php">Inicio</a></li>
				<li><a href="legalrepresentatives.php">Representantes legales</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
		<div class="wrapper">
			<h2>Datos de Facebook</h2>
			<?php
				if(isset($accessToken)){
				    if(isset($_SESSION['facebook_access_token'])){
				        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
				    }else{
				        // Put short-lived access token in session
				        $_SESSION['facebook_access_token'] = (string) $accessToken;
				        
				          // OAuth 2.0 client handler helps to manage access tokens
				        $oAuth2Client = $fb->getOAuth2Client();
				        
				        // Exchanges a short-lived access token for a long-lived one
				        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
				        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
				        
				        // Set default access token to be used in script
				        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
				    }
				    
				    // Redirect the user back to the same page if url has "code" parameter in query string
				    if( isset($_GET['code']) ){
				        header('Location: ./facebookprofile.php');
				    }
				    
				    // Getting user facebook profile info
				    try {
				        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,cover,picture.type(large)');
				        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
				    } catch(FacebookResponseException $e) {
				        echo 'Graph returned an error: ' . $e->getMessage();
				        session_destroy();
				        // Redirect user back to app login page
				        header("Location: ./");
				        exit;
				    } catch(FacebookSDKException $e) {
				        echo 'Facebook SDK returned an error: ' . $e->getMessage();
				        exit;
				    }
				    
				    // Initialize User class
				    $user = new Facebook();
				    
				    // Insert or update user data to the database
				    $fbUserData = array(
				        'oauth_provider'=> 'facebook',
				        'oauth_uid'     => $fbUserProfile['id'],
				        'first_name'    => $fbUserProfile['first_name'],
				        'last_name'     => $fbUserProfile['last_name'],
				        'email'         => $fbUserProfile['email'],
				        'picture'       => $fbUserProfile['picture']['url']
				    );
				    $userData = $user->checkUser($fbUserData);
				    
				    // Put user data into session
				    $_SESSION['userData'] = $userData;
				    
				    // Get logout url
				    //$logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');
				    
				    // Render facebook profile data
				    if(!empty($userData)){
				        header("Location: /proyecto/profile.php");
				    }else{
				        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
				    }
			}else{
			    $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
			  
			    $output = '<a href="'.htmlspecialchars($loginURL).'">Linkear mi cuenta de FB</a>';
			}
			echo $output;
			?>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>