<?php
include "./idk/php.php"; 
$conn = login();

$teamid = URLParameterExtraction();
$sql = "SELECT vragenId FROM companies WHERE id=" . $teamid;
$vragenIdResult = $conn->query($sql);
$vragenIdArray = mysqli_fetch_array($vragenIdResult);
$vragenId = $vragenIdArray[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team informatie</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
    <meta name="description" content="JGM serious eXperiences">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
</head>
<body>
    <?php 
    include "header.html";
    include "headerblock.html";
    ?>
    <h1>Analyse rapport gegevens</h1>
    <p>Deze pagina is weinig veranderd ten opzichte van de analyzer, Enkel de team opbouw is gelinkt aan de vragenlijst en de gender distributie is toegevoegd. De mogelijkheid om de team informatie aan te passen is weggelaten, aangezien dit al mogelijk was en weinig tot geen invloed heeft op dit project.</p>
    <h2>Algemene gegevens</h2>
        <p>dit vak is opzettelijk leeg gelaten.</p>
    <h2>Theoretische assesments</h2>
    <?php
		$sql = "SELECT * FROM questionaires WHERE id=" . $vragenId; //maybe I don't need all so can replace the star
		$result1 = $conn->query($sql);
        $row = mysqli_fetch_array($result1);

        $sql = "SELECT COUNT(*) as count,AVG(leeftijd) as avg_age FROM answers WHERE teamid=" . $teamid;
		$result2 = $conn->query($sql);
        $responsecount = mysqli_fetch_array($result2);

        $sql = "SELECT COUNT(*) as welErvaring FROM answers WHERE ervaring='Ja' AND teamid=" . $teamid;
		$result3 = $conn->query($sql);
        $ervaringcount = mysqli_fetch_array($result3);

        $sql = "SELECT COUNT(*) FROM answers WHERE gender='Man' AND teamid=" . $teamid;
		$result4 = $conn->query($sql);
        $mancount = mysqli_fetch_array($result4);

        $sql = "SELECT COUNT(*) FROM answers WHERE gender='Vrouw' AND teamid=" . $teamid;
		$result5 = $conn->query($sql);
        $vrouwcount = mysqli_fetch_array($result5);

        $sql = "SELECT COUNT(*) FROM answers WHERE gender='Anders' AND teamid=" . $teamid;
		$result6 = $conn->query($sql);
        $anderscount = mysqli_fetch_array($result6);

		echo "<table class='stylish'><tr><th>Titel</th><th>URL formulier</th><th>Responses</th></tr>"; // start a table tag in the HTML
        echo "<tr><td>" . $row['title'] . "</td><td><a href='questionaire.php?team=" . $teamid . "'>questionaire.php?team=" . $teamid . "</a></td><td>" . $responsecount["count"] . " responses</td></tr></table>";
		?>
    <h2>Team opbouw</h2>
    <table>
		<tbody>
            <tr>
				<td>Aantal teamleden:</td>
				<td><? echo $responsecount["count"]; ?></td>
			</tr><tr>
				<td>Gemiddelde leeftijd:</td>
				<td><? echo number_format($responsecount["avg_age"], 2); ?></td>
			</tr><tr>
				<td>Percentage ervaring Escaperoom:</td>
				<td><? echo number_format($ervaringcount["welErvaring"]/$responsecount["count"]*100, 0) . "%"; ?></td>
			</tr><tr>
				<td>Genderverdeling (m/v/a):</td>
				<td><? echo number_format($mancount[0]/$responsecount["count"]*100, 0) . "/" . number_format($vrouwcount[0]/$responsecount["count"]*100, 0) . "/" . number_format($anderscount[0]/$responsecount["count"]*100, 0) ?></td>
			</tr>
		 </tbody>
    </table>
    
</body>
</html>