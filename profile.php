<?php
session_start();
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}
include 'functions.php';
$profileData = profileData($_SESSION["user"]);
$googleData = googleData($_SESSION["user"]);
$facebookData = facebookData($_SESSION["user"]);
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
			<form action="#" class="profileform">
				<label for="name">Nombre</label>
				<input type="text" name="name" value="<?php echo $profileData["nombre"] ?>" />
				<label for="cedula">Cedula</label>
				<input type="text" name="cedula" value="<?php echo $profileData["cedula"] ?>" />
				<label for="email">Email</label>
				<input type="text" name="email" value="<?php echo $profileData["email"] ?>" />
				<label for="password">Password</label>
				<input type="password" name="password" value="<?php echo $profileData["password"] ?>" />
				<a class="button submit" href="#">Enviar</a>
			</form>
			<h2>Datos de Google</h2>
			<?php
				if( count($googleData) > 0 ){
					$output = '<img src="'.$googleData['picture'].'" width="300" >';
				    $output .= '<br/>Nombre: ' . $googleData['nombre'];
				    $output .= '<br/>Email: ' . $googleData['email'];
				    echo $output;
				}else{ ?>
					<a href="googleprofile.php"><img src="img/google.png" alt=""></a>
			<?php
				}
			?>
			<h2>Datos de Facebook</h2>
			<?php
				if( count($facebookData) > 0 ){
					$output = '<img src="'.$facebookData['picture'].'" width="300" >';
				    $output .= '<br/>Nombre: ' . $facebookData['nombre'];
				    $output .= '<br/>Email: ' . $facebookData['email'];
				    echo $output;
				}else{ ?>
					<a href="facebookprofile.php"><img src="img/fb.png" alt=""></a>
			<?php
				}
			?>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>