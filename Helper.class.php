<?php
class Helper {
	
	private  $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function cleanInput ($input) {
		
		// "   tere tulemast    "
		$input = trim($input);
		// "tere tulemast"
		
		// "tere \\tulemast"
		$input = stripslashes($input);
		// "tere tulemast"
		
		// "<"
		$input = htmlspecialchars($input);
		// "&lt;"
		
		return $input;
	}
	
}?>