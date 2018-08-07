<?php
require "PHPMailer.php";
use PHPMailer\PHPMailer\PHPMailer;

if( isset($_POST['checkUser']) ){
	checkUser($_POST['user'], $_POST['password']);
}

if( isset($_POST['recoverPassword']) ){
	recoverPassword($_POST['user']);
}

if( isset($_POST['updateProfile']) ){
	session_start();
	updateProfile($_POST['nombre'],$_POST['cedula'],$_POST['email'],$_POST['password'],$_SESSION["user"]);
}

if( isset($_POST['updateRepresentante']) ){
	updateRepresentante($_POST['nombre'],$_POST['cedula'],$_POST['email'],$_POST['id']);
}

if( isset($_POST['addRepresentante']) ){
	addRepresentante($_POST['nombre'],$_POST['cedula'],$_POST['email']);
}

if( isset($_POST['changePassword']) ){
	changePassword($_POST['newpassword'],$_POST['user']);
}

function connectDB(){
	$enlace = mysqli_connect("mysql23.ezhostingserver.com", "contribuyentes", "Contribuyentes123.", "contribuyentes");
	if ( !$enlace->connect_error) {
	   return $enlace;
	}
}

function getFBConfig(){
	$mysqli = connectDB();
	$sql = "SELECT * from config where nombre = \"facebook\" ";
	$resultado = $mysqli->query($sql);
	if($resultado->num_rows > 0){
		$row = $resultado->fetch_assoc();
		$fBConfig = [
		    "appId" => $row["appid"],
		    "appSecret" => $row["appsecret"]
		];
		return $fBConfig;
	}
}

function getGoogleConfig(){
	$mysqli = connectDB();
	$sql = "SELECT * from config where nombre = \"google\" ";
	$resultado = $mysqli->query($sql);
	if($resultado->num_rows > 0){
		$row = $resultado->fetch_assoc();
		$googleConfig = [
		    "appId" => $row["appid"],
		    "appSecret" => $row["appsecret"]
		];
		return $googleConfig;
	}
}

function checkUser($user,$password){
	$mysqli = connectDB();
	$sql = "SELECT * from usuarios where email = \"$user\" and password = \"$password\"";
	$resultado = $mysqli->query($sql);
	if($resultado->num_rows > 0){
		echo "true";
		$row = $resultado->fetch_assoc();
		session_start();
		$_SESSION["user"] = $row["id"];
	}else{
		echo "false";
	}
}

function recoverPassword($user){
	$mysqli = connectDB();
	$sql = "SELECT * from usuarios where email = \"$user\"";
	$resultado = $mysqli->query($sql);
	if($resultado->num_rows > 0){
		sendRecoverEmail($user);
		echo "true";
	}else{
		echo "false";
	}
}

function changePassword($newpassword,$user){
	$mysqli = connectDB();
	$sql = "UPDATE usuarios SET password = \"$newpassword\" where email = \"$user\" ";
	if ($mysqli->query($sql) === TRUE) {
    	echo "true";
	} else {
	    echo "false";
	}
}

function sendRecoverEmail($email){
	$mail = new PHPMailer;
	$mail->setFrom('contribuyentes@example.com', 'Sistema Contribuyentes');
	$mail->addAddress($email);
	$mail->Subject = 'Recuperacion de password';
	$mail->isHTML(true);
	$message = "
	<html>
		<head>
			<title>Password recovery</title>
		</head>
		<body>
			<p>Para cambiar tu contraseña ingresa al siguiente link:</p>
			<a href=\"http://localhost/proyecto/recover.php?id=".$email."\">Recuperar mi password</a>
		</body>
	</html>
	";
	$mail->Body = $message;
	
	$mail->send();
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <webmaster@example.com>' . "\r\n";
	mail($email,"Recuperacion de password",$message,$headers);
}

function updateProfile($name, $id, $email, $password,$user){
	$mysqli = connectDB();
	$sql = "UPDATE usuarios SET nombre = \"$name\" , cedula = \"$id\", email = \"$email\",
	password = \"$password\" where id = \"$user\" ";
	if ($mysqli->query($sql) === TRUE) {
    	echo "true";
	} else {
	    echo "false";
	}
}

function updateRepresentante($name, $cedula, $email,$id){
	$mysqli = connectDB();
	$sql = "UPDATE representantes SET nombre = \"$name\" , cedula = \"$cedula\", email = \"$email\" where id = \"$id\" ";
	if ($mysqli->query($sql) === TRUE) {
    	echo "true";
	} else {
	    echo "false";
	}
}

function addRepresentante($name, $cedula, $email){
	$mysqli = connectDB();
	session_start();
	$sql = "INSERT INTO representantes (nombre, cedula, email, representa) VALUES (\"$name\", \"$cedula\", \"$email\", ".$_SESSION["user"]." ) ";
	if ($mysqli->query($sql) === TRUE) {
    	echo "true";
	} else {
	    echo "false";
	}
}

function profileData ($user){
	$mysqli = connectDB();
	$sql = "SELECT * from usuarios where id = \"$user\"";
	$resultado = $mysqli->query($sql);
	if($resultado->num_rows > 0){
		$row = $resultado->fetch_assoc();
		$profileDataArray = [
		    "nombre" => $row["nombre"],
		    "cedula" => $row["cedula"],
		    "email" => $row["email"],
		    "password" => $row["password"],
		];
		return $profileDataArray;
	}
}

function googleData ($user){
	$mysqli = connectDB();
	$sql = "SELECT * from google where owner = \"$user\"";
	$resultado = $mysqli->query($sql);
	$googleDataArray = [];
	if($resultado->num_rows > 0){
		$row = $resultado->fetch_assoc();
		$googleDataArray = [
		    "nombre" => $row["first_name"]." ".$row["last_name"],
		    "email" => $row["email"],
		    "picture" => $row["picture"]
		];	
	}
	return $googleDataArray;
}

function facebookData ($user){
	$mysqli = connectDB();
	$sql = "SELECT * from facebook where owner = \"$user\"";
	$resultado = $mysqli->query($sql);
	$facebookDataArray = [];
	if($resultado->num_rows > 0){
		$row = $resultado->fetch_assoc();
		$facebookDataArray = [
		    "nombre" => $row["first_name"]." ".$row["last_name"],
		    "email" => $row["email"],
		    "picture" => $row["picture"]
		];	
	}
	return $facebookDataArray;
}

function getRepresentantes ($user){
	$mysqli = connectDB();
	$sql = "SELECT * from representantes where representa = \"$user\"";
	$resultado = $mysqli->query($sql);
	return $resultado->fetch_all(MYSQLI_ASSOC);
}

function getRepresentante ($representanteID){
	$mysqli = connectDB();
	$sql = "SELECT * from representantes where id = \"$representanteID\"";
	$resultado = $mysqli->query($sql);
	return $resultado->fetch_all(MYSQLI_ASSOC);
}

function deleteRepresentante ($representanteID){
	$mysqli = connectDB();
	$sql = "DELETE from representantes where id = \"$representanteID\"";
	if ($mysqli->query($sql) === TRUE) {
    	return true;
	} else {
	    return false;
	}
}

?>