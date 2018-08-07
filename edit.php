<?php
session_start();
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}
include 'functions.php';
$representante = getRepresentante($_GET["id"]);
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
			<form action="#" class="editform">
				<label for="name">Nombre del representante</label>
				<input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
				<input type="text" name="name" value="<?php echo $representante[0]["nombre"] ?>" />
				<label for="cedula">Cedula</label>
				<input type="text" name="cedula" value="<?php echo $representante[0]["cedula"] ?>" />
				<label for="email">Email</label>
				<input type="text" name="email" value="<?php echo $representante[0]["email"] ?>" />
				<a class="button submit" href="#">Enviar</a>
			</form>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>