<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Sistema contribuyentes</title>
		<link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/styles.css" />
	</head>
	<body>
		<nav>
			<h1>Sistema de contribuyentes</h1>
		</nav>
		<div class="wrapper">
		<?php
		if( isset($_GET['id']) ){
		?>
			<form action="#" class="newpasswordform">
				<input type="hidden" name="user" value="<?php echo $_GET['id'] ?>" />
				<label for="password">New password</label>
				<input type="password" name="password" />
				<label for="passwordconfirm">Confirm new password</label>
				<input type="password" name="passwordconfirm" />
				<a class="button submit" href="#">Cambiar contraseña</a>
			</form>
		<?php	
		}else{
		?>	
			<form action="#" class="recoverform">
				<label for="user">Username</label>
				<input type="text" name="user" />	
				<a class="button submit" href="#">Recuperar contraseña</a>
			</form>		
		<?php } ?>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>