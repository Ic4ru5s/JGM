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
    <title>JGM serious eXperiences</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
    <meta name="description" content="JGM serious eXperiences">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
</head>
<body>
    <div id="main">
        <div class="headerblock">
		    <a href="index.php">Sessies</a> |  
            <a href="overviews.php">Overzichten</a> | 
            <a href="company.php">Mijn gegevens</a> | 
            <a href="sources.php">Hoe werkt het?</a>
        </div>
    </div>
    <div>
		<div class="inner">
			<h1>Rapporten</h1>
			<button class="btn line_button_black float_right " style="margin-top:15px;" onclick="window.location.href='new_report.php'">+ Rapport</button>
            <button class="btn line_button_black float_right " style="margin-top:15px;" onclick="window.location.href='questionaire.php'">Questionaire</button>
        </div>

        <?php
			$sql = "SELECT * FROM companies"; //You don't need a ; like you do in SQL
			$result = $conn->query($sql);
				
			echo "<table><tr><td>Datum</td><td>Teamnaam</td><td>Bedrijfsnaam</td><td>Vaardigheden</td><td>Status</td><td></td></tr>"; // start a table tag in the HTML
				
			while($row = $result->fetch_assoc()){   //Creates a loop to loop through results
			echo "<tr><td>". $row['datum'] . "</td><td>" . $row['teamnaam'] . "</td><td>" . $row['bedrijfsnaam'] . "</td><td>Vaardigheden</td><td>Status</td><td>"; 
            echo "<button onclick=" . '"'. "window.location.href=" . "'QRcode.php?team=". $row["id"] ."'" . '"' . ">Questionaire code</button>";
            echo "</td></tr>";
			}
				
			echo "</table>"; //Close the table in HTML
			?>

    </div>
</body>
</html>