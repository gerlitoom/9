<?php 
	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas kasutaja tahab välja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if (	isset($_POST["note"]) && 
			isset($_POST["color"]) && 
			!empty($_POST["note"]) && 
			!empty($_POST["color"]) 
	) {
		
		$note = cleanInput($_POST["note"]);
		
		saveNote($note, $_POST["color"]);
		
	}
	
	$Note->getAllNotes();
	
	//echo "<pre>";
	//var_dump($notes);
	//echo "</pre>";
?>

<h1>Data</h1>
<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">Logi välja</a>
</p>

<form method="POST">
<textarea name="note" rows="4" cols="50" value="text"></textarea>
<br>
<input name="color" type="color" style="width: 70px; height: 30px" value="#BBBBBB">
<br><br>
 <input type="submit">
 </form>
 <br><br>

<h2>Kommentaarid</h2>


<?php 
	//iga liikme kohta massiivis
	foreach ($notes as $n) {
		
		$style = "width:370px; 
				  min-height:50px; 
				  border: 1px solid gray;
				  background-color: ".$n->noteColor.";";
		
		echo "<p style='  ".$style."  '>".$n->note."</p>";
	}
?>


<h2 style="clear:both;">Tabel</h2>
<?php 
	$html = "<table>";
		
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
	foreach ($notes as $note) {
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
			$html .= "<td><a href='edit.php?id=".$note->id."'>edit.php</a></td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
?>