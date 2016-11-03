<?php 

	require("../../config.php");
	
	session_start(); 
	
	$database = "if16_gerltoom";
	
	//võid globals ära kustutada
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
	
	require("User.class.php");
	$User = new User($mysqli);
	
	require("Interests.class.php");
	$Interests = new Interests($mysqli);
	
	require("Note.class.php");
	$Note = new Note($mysqli);
	

?>