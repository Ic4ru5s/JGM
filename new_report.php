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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New report</title>
</head>
<body>
<div class="inner">
	<h1>Nieuw rapport aanmaken</h1>
		<form action="" method="POST">
			<table>
			<tbody><tr>
					<td>Teamnaam*:</td><td><input type="text" value="" name="team_name" required=""></td>
				</tr><tr>
					<td>Bedrijfsnaam:</td><td><input type="text" value="" name="company_name"></td>
				</tr><tr>
					<td>Escaperoom:</td><td><select name="escaperoom_id"><option value="1" selected="">Het kantoor</option><option value="2">Planetarium</option><option value="3">Planetarium</option><option value="4">Directeurskamer</option><option value="5">Elze's Zodiac</option><option value="6">Directeur</option></select></td>
				</tr><tr>
					<td>Industrie:</td><td><select name="industry_id"><option value="1" selected="">Banken</option><option value="2">Onderwijs</option><option value="3">ICT</option><option value="4">Overig</option><option value="6">Prive</option></select></td>
				</tr>
				</tbody>
            </table>

            <?php
				$sql = "SELECT * FROM questionaires"; //You don't need a ; like you do in SQL
				$result = $conn->query($sql);
				
				echo "<table>"; // start a table tag in the HTML
				
				while($row = $result->fetch_assoc()){   //Creates a loop to loop through results
				echo "<tr><td><input type='radio' name='questionaire' value='". $row['id'] . "'></td><td>" . htmlspecialchars($row['title']) . "</td><td>" . htmlspecialchars($row['questions']) . "</td></tr>";  //$row['index'] the index here is a field name
				}

				echo "<tr><td></td><td></td><td><button onclick=" . '"window.location.href=' ."'setup_questionaire.php'" . '">Create new questionaire</button></td></tr>';
				
				echo "</table>"; //Close the table in HTML
				

				

				$datum = date("Y-m-d");
				$sql = "INSERT INTO companies (teamnaam, bedrijfsnaam, escaperoom, industrie, datum, vragenId) VALUES ('$_POST[team_name]', '$_POST[company_name]', '$_POST[escaperoom_id]', '$_POST[industry_id]', '$datum', '$_POST[questionaire]')"; //add question id to this
				if ($conn->query($sql)) {

				} else {
					echo "Not able to add record";
					print_r($sql->errorInfo());
				}
			?>
			<input type="submit">
        </form>
	</div>
</body>
</html>