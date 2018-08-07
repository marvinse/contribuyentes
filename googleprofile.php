<?php
session_start();
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}
include 'functions.php';

//Include GP config file && Google class
include_once 'gpConfig.php';
include_once 'Google.php';
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
			<h2>Datos de Google</h2>
			<?php
				if( isset($_GET['code']) ){
				    $gClient->authenticate($_GET['code']);
				    $_SESSION['token'] = $gClient->getAccessToken();
				    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
				}

				if (isset($_SESSION['token'])) {
				    $gClient->setAccessToken($_SESSION['token']);
				}

				if ($gClient->getAccessToken()) {
					$gpUserProfile = $google_oauthV2->userinfo->get();
					$user = new Google();
				    
				    //Insert or update user data to the database
				    $gpUserData = array(
				        'oauth_provider'=> 'google',
				        'oauth_uid'     => $gpUserProfile['id'],
				        'first_name'    => $gpUserProfile['given_name'],
				        'last_name'     => $gpUserProfile['family_name'],
				        'email'         => $gpUserProfile['email'],
				        'gender'        => $gpUserProfile['gender'],
				        'locale'        => $gpUserProfile['locale'],
				        'picture'       => $gpUserProfile['picture'],
				        'link'          => $gpUserProfile['link']
				    );
				    $userData = $user->checkUser($gpUserData);
				    $_SESSION['userData'] = $userData;

					if(!empty($userData)){
				        header("Location: /proyecto/profile.php");
				    }else{
				        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
				    }
				}else{
					$authUrl = $gClient->createAuthUrl();
					$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">Linkear mi cuenta de google</a>';
				}
				echo $output;
			?>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>