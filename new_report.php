<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "jgm-se";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

if (!empty($_POST['questionaireTitle']) && !empty($_POST['idlist'])) {
	$sql = "INSERT INTO questionaires (title, questions) VALUES ('$_POST[questionaireTitle]', '$_POST[idlist]')";
	if ($conn->query($sql) !== TRUE) {
		echo "Error creating questionaire: " . $conn->error;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New report</title>
	<link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
</head>
<body>
<?php 
    include "header.html";
    include "headerblock.html";
    ?>
	<div class="inner">
		<h1>Nieuw rapport aanmaken</h1>
		<p>Op deze pagina kan net als op de analyser een nieuwe rapportage gemaakt worden. De optie om zelf nieuwe vragenlijsten toe te voegen is geimplementeerd. Deze mogelijkheid is te vinden onder de "Create new questionaire" knop.</p>
		<form action="index.php" method="POST">
			<table>
			<tbody><tr>
					<td><label for="team_name">Teamnaam*:</label></td>
					<td><input type="text" value="" name="team_name" required="" id="team_name"></td>
				</tr><tr>
					<td><label for="company_name">Bedrijfsnaam:</label></td>
					<td><input type="text" value="" name="company_name" id="company_name"></td>
				</tr><tr>
					<td><label for="escaperoom_id">Escaperoom:</label></td>
					<td><select name="escaperoom_id" id="escaperoom_id">
						<option value="1" selected="">Het kantoor</option>
						<option value="2">Planetarium</option>
						<option value="3">Planetarium</option>
						<option value="4">Directeurskamer</option>
						<option value="5">Elze's Zodiac</option>
						<option value="6">Directeur</option></select>
					</td>
				</tr><tr>
					<td><label for="industry_id">Industrie:</label></td>
					<td><select name="industry_id" id="industry_id">
						<option value="1" selected="">Banken</option>
						<option value="2">Onderwijs</option>
						<option value="3">ICT</option>
						<option value="4">Overig</option>
						<option value="6">Prive</option>
					</select></td>
				</tr>
				</tbody>
            </table>

            <?php
				$sql = "SELECT * FROM questionaires"; 
				$result = $conn->query($sql);
				
				echo "<table class='stylish'><tr><th></th><th>Questionaire</th><th>Vragen</th></tr>"; // start a table tag in the HTML
				
				while($row = $result->fetch_assoc()){   //Creates a loop to loop through results
				echo "<tr><td><input type='radio' name='questionaire' value='". $row['id'] . "'></td><td>" . htmlspecialchars($row['title']) . "</td><td>" . htmlspecialchars($row['questions']) . "</td></tr>";  //$row['index'] the index here is a field name
				}
				echo "<tr><td></td><td></td><td><button type='button' onclick=" . '"window.location.href=' ."'setup_questionaire.php'" . '">Create new questionaire</button></td></tr>';
				echo "</table>"; //Close the table in HTML
				$conn -> close();
			?>
			<input type="submit">
        </form>
	</div>
	<?php include "footer.html";?>
</body>
</html>