<?php
session_start();
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}
include 'functions.php';
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
			<table class="table">
				<thead>
					<tr>
					  <th scope="col">#</th>
					  <th scope="col">Representante</th>
					  <th scope="col">Cedula</th>
					  <th scope="col">Correo</th>
					  <th scope="col">Accion</th>
					</tr>
				</thead>
				<tbody>
						<?php
							$representantes = getRepresentantes( $_SESSION["user"] );
							//print_r ($representantes);
							for ($i=0; $i < count($representantes); $i++) { 
								echo "<tr>";
								echo "<td>".($i+1)."</td>";
								echo "<td>".$representantes[$i]["nombre"]."</td>";
								echo "<td>".$representantes[$i]["cedula"]."</td>";
								echo "<td>".$representantes[$i]["email"]."</td>";
								echo "<td><a href=\"edit.php?id=".$representantes[$i]["id"]."\">Editar</a> | <a href=\"delete.php?id=".$representantes[$i]["id"]."\">Eliminar</a></td>";
								echo "</tr>";
							}
						?>
				</tbody>
			</table>
			<a class="button" href="add.php">Agregar nuevo representante</a>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>