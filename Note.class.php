<?php
class Note {
	
	private  $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}

	function getSingleNoteData($edit_id){
    
		//echo "id on ".$edit_id;
		
		$stmt = $this->connection->prepare("SELECT note, color FROM colorNotes WHERE id=?");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($note, $color);
		$stmt->execute();
		
		//tekitan objekti
		$n = new Stdclass();
		
		//saime �he rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$n->note = $note;
			$n->color = $color;
			
			
		}else{
			// ei saanud rida andmeid k�tte
			// sellist id'd ei ole olemas
			// see rida v�ib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $n;
		
	}
	function updateNote($id, $note, $color){
		
		$stmt = $this->connection->prepare("UPDATE colorNotes SET note=?, color=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("ssi",$note, $color, $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "salvestus �nnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deleteNote($id){
		
		$stmt = $this->connection->prepare("UPDATE colorNotes SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "salvestus �nnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function saveNote($note, $color) {
	
		$stmt = $this->connection->prepare("INSERT INTO colorNotes (note, color) VALUES (?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("ss", $note, $color );
		if ( $stmt->execute() ) {
			echo "salvestamine �nnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function getAllNotes() {
		
		$stmt = $this->connection->prepare("
			SELECT id, note, color
			FROM colorNotes
			WHERE deleted IS NULL
		");
		
		$stmt->bind_result($id, $note, $color);
		$stmt->execute();
		
		$result = array();
		
		// ts�kkel t��tab seni, kuni saab uue rea AB'i
		// nii mitu korda palju SELECT lausega tuli
		while ($stmt->fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->noteColor = $color;
			
			
			array_push($result, $object);
			
		}
		
		return $result;
		
	}
	
}?>