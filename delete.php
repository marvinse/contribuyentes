<?php
session_start();
include 'functions.php';
if(!$_SESSION["user"]){
	header("Location: /proyecto");
}else{
	$userToDelete = $_GET["id"];
	deleteRepresentante($userToDelete);
	header("Location: /proyecto/legalrepresentatives.php");
}
?>