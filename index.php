<?php
include "php.php"; 
$conn = login();

$datum = date("Y-m-d");
if (!empty($_POST['team_name']) && !empty($_POST['questionaire'])) { // This segment stores the result of the new report in the companies table
	$sql = "INSERT INTO companies (teamnaam, bedrijfsnaam, escaperoom, industrie, datum, vragenId) VALUES ('$_POST[team_name]', '$_POST[company_name]', '$_POST[escaperoom_id]', '$_POST[industry_id]', '$datum', '$_POST[questionaire]')";
	if (!$conn->query($sql)) {
		echo "Not able to add record";
		print_r($sql->errorInfo());
	}
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
</head>
<body>
    <?php 
    include "header.html";
    include "headerblock.html";
    ?>
    <div>
		<div class="inner">
			<h1>Rapporten</h1>
            <p>Deze pagina is over het algemeen onveranderd, er missen alleen een aantal functionaliteiten die niet direct relevant waren voor dit project. De "+ Rapport" knop maakt nog steeds een nieuwe rapportage voor een nieuw team aan. De "Questionaire code" knop stuurt je naar een pagina met een QR code die de deelnemers naar de enquete stuurt.</p>
			<button class="btn line_button_black float_right" onclick="window.location.href='new_report.php'">+ Rapport</button>
        </div>

        <?php
			$sql = "SELECT * FROM companies"; 
			$result = $conn->query($sql);
				
			echo "<table class='stylish'><tr><th>Datum</th><th>Teamnaam</th><th>Bedrijfsnaam</th><th>Vaardigheden</th><th>Status</th><th></th></tr>"; // A table to house the company information is started
				
			while($row = $result->fetch_assoc()){ // this loop makes a row in the table for all companies in the table
			echo "<tr><td>". $row['datum'] . "</td><td>" . $row['teamnaam'] . "</td><td>" . $row['bedrijfsnaam'] . "</td><td>Vaardigheden</td><td>Status</td><td>"; 
            echo "<button class='button_link btn button_black  small_btn' onclick=" . '"'. "window.location.href=" . "'qrcode.php?team=". $row["id"] ."'" . '"' . ">Questionaire code</button>"; // makes the button to the questionaire
            echo "<button class='button_link btn button_black  small_btn' onclick=" . '"'. "window.location.href=" . "'teampage.php?team=". $row["id"] ."'" . '"' . ">Gegevens</button>"; // makes a button to the team information page
            echo "</td></tr>";
			}
				
			echo "</table>";
            $conn -> close();
		?>
    </div>
    <?php include "footer.html";?>
</body>
</html>