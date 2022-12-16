<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sources</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    include "header.html";
    include "headerblock.html";
    include "./idk/php.php"; 
    $conn = login();
    ?>
    <div>
        <h1>Antwoorden vragenlijst</h1>
        <p>Op deze pagina staan alle resultaten van de vragenlijst. op het moment zijn ze gesorteerd op moment van invullen.</p>
    </div>

    <?php
        // start table
        echo "<table class='stylish'><tr>";

        // build the table header
        $sql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='jgm-se' AND TABLE_NAME='answers'";
        $result1 = $conn->query($sql);

        while($row1 = $result1->fetch_assoc()){
			echo "<th>" . $row1["column_name"] . "</th>";
		}

        echo "</tr>";

        // add the rows with answers
        $sql = "SELECT * FROM answers"; 
        $result2 = $conn->query($sql);
            
        while($row2 = $result2->fetch_assoc()){   //Creates a loop to loop through results
            echo "<tr>";
            foreach($row2 as $tag => $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
    ?>

</body>
</html>