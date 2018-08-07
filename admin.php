<?php
session_start();
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}
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
			<a class="button" href="profile.php">Modificar mis datos</a>
			<a class="button" href="legalrepresentatives.php">Editar representantes legales</a>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>