<?php
include "php.php"; 
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
		$sql1 = "SELECT title FROM questionaires WHERE id=" . $vragenId; // these statements select the required data for the team analysis done below
        $title = sqlToArray($sql1, $conn);

        $sql2 = "SELECT COUNT(*) as count,AVG(leeftijd) as avg_age FROM answers WHERE teamid=" . $teamid;
        $responsecount = sqlToArray($sql2, $conn);

        $sql3 = "SELECT COUNT(*) as welErvaring FROM answers WHERE ervaring='Ja' AND teamid=" . $teamid;
        $ervaringcount = sqlToArray($sql3, $conn);

        $sql4 = "SELECT COUNT(*) FROM answers WHERE gender='Man' AND teamid=" . $teamid;
        $mancount = sqlToArray($sql4, $conn);

        $sql5 = "SELECT COUNT(*) FROM answers WHERE gender='Vrouw' AND teamid=" . $teamid;
        $vrouwcount = sqlToArray($sql5, $conn);

        $sql6 = "SELECT COUNT(*) FROM answers WHERE gender='Anders' AND teamid=" . $teamid;
        $anderscount = sqlToArray($sql6, $conn);

		echo "<table class='stylish'><tr><th>Titel</th><th>URL formulier</th><th>Responses</th></tr>";
        echo "<tr><td>" . $title['title'] . "</td><td><a href='questionaire.php?team=" . $teamid . "'>questionaire.php?team=" . $teamid . "</a></td><td>" . $responsecount["count"] . " responses</td></tr></table>";
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