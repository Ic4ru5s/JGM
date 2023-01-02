<?php
include "php.php"; 
$conn = login();

$currentoption = 0;
$optionlist = "";       

while ($currentoption <= $_POST["optioncount"]) { //creates the list of options stored in the table
$name = "option" . $currentoption;
    if (!empty($_POST[$name])) {
        $optionlist = $optionlist . $_POST[$name] . "|";
    }       
$currentoption++;
}
$optionlistTrimmed = rtrim($optionlist, "|"); 


if (!empty($_POST["question"]) && !empty($_POST["tag"]) && ((($_POST["answertype"] == "radio" || $_POST["answertype"] == "checkbox") && !empty($optionlistTrimmed)) || ($_POST["answertype"] != "radio" && $_POST["answertype"] != "checkbox"))) { // The if statement is a monstrosity but it stores the new questions and prevents empty rows.
    $sql = "INSERT INTO questions (question, tag, answertype, options) VALUES ('$_POST[question]', '$_POST[tag]', '$_POST[answertype]', '$optionlistTrimmed')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating question: " . $conn->error;
        }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionaire setup</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    include "header.html";
    include "headerblock.html";
    ?>

    <h1>Nieuwe vragenlijst maken</h1>
	<p>Op deze pagina kun je door de gewenste vragen aan te vinken en een titel in te vullen in de balk een nieuwe vragenlijst genereren.</p>

    <div>  <!-- Question display panel -->
        <form action="new_report.php" method="post"> 
            <label for="questionaireTitle">Titel vragenlijst: </label><input type="text" name="questionaireTitle" id="questionaireTitle" required><br>
            <?php
                $sql = "SELECT id, question, tag, options FROM questions";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="questionbox">';
                        echo '<input type="checkbox" name="selector' . $row["id"] . '" onclick="selection(' . $row["id"] . ')" id=' . $row["id"] . ' class="checkbox">';
                        echo '<label for=' . $row["id"] . ' class="question">' . $row["question"] . '</label>';
                        
                        if (!empty($row['options'])) {// run a loop to put options in a list
                            echo '<ul class="optionlist">';
                        
                            $options = explode("|", $row['options']);
                            foreach ($options as $option) {
                                echo '<li class="option">' . $option . '</li>';
                            }
                            echo '</ul>';
                        }
                        echo '<p class="functions">Add functionalities here</p></div>';
                    }
                } else {
                    echo "0 results";
                }
            ?>
            <input type="hidden" id="idlist" name="idlist">
            <input type="submit">
        </form>
    </div>

    <script> // prevents resubmission when refreshing, might change for post-refresh-get if ample reason to
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>

    <div> <!-- Question submission panel -->
        <br>
        <form action="setup_questionaire.php" method="post"> <!-- Collect the data required to make question cards -->
            <label for="question">Question: </label><input type="text" name="question" id="question"><br>
            <label for="tag">Tag: </label><input type="text" name="tag" id="tag"><br>
            <label for="answertype">Answer type: </label><select name="answertype" id="answertype" onChange="unlockOption(this)">
                <option value="text">Tekstvak</option>
                <option value="radio">Radio button</option>
                <option value="date">Datum</option>
                <option value="number">Getal</option>
                <option value="checkbox">Checkbox</option>
            </select><br>
            <div id="optionlist"></div>
            <input type="hidden" id="optioncount" name="optioncount">
            <input type="submit">
        </form>

        <script>
            const optionlist = document.getElementById("optionlist");
            let optioncounter = 0

            function unlockOption(optionvalue) {
                let option = optionvalue.value;
                let target = document.getElementById("option0") 

                if ((option === "radio" || option === "checkbox") && !(target)) { //check if option0 already exists if not, and radio or check selected. creates new option 0
                    optionlist.innerHTML += "<label for='option0'>Options:</label><br>" + '<input type="text" name="option0" id="option0">' + '<button type="button" onclick="addOption()">+</button>'; // adds the first line option input
                    document.getElementById("optioncount").value = optioncounter
                } else if (option !== "radio" && option !== "checkbox") { // clears the option section if neither radio nor check are selected
                    optionlist.innerHTML = ""
                }
            }

            function addOption() { // creates more input elements
                optioncounter += 1
                optionlist.innerHTML += '<br><input type="text" name="option' + optioncounter + '">';
                document.getElementById("optioncount").value = optioncounter
            }

            questions = ""

            function selection(identifier) {
                let checkBox = document.getElementById(identifier)
                stringid = identifier + "|"

                if (checkBox.checked && !questions.includes(stringid)) {
                    questions += stringid
                } else if (!checkBox.checked && questions.includes(stringid)) {
                    questions = questions.replace(stringid, "")
                }
                document.getElementById("idlist").value = questions
            }
        </script>

        <?php //first check for empty cells to prevent errors
            if (!empty($_POST['tag'])) {
                $sql = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='jgm-se' AND TABLE_NAME='answers' AND column_name='$_POST[tag]'"; // checks if tag exists
                $tagcountarray = sqlToArray($sql, $conn);

                //find correct datatype
                if ($_POST['answertype'] == "text" || $_POST['answertype'] == "radio" || $_POST['answertype'] == "checkbox") {
                    $datatype = " VARCHAR(255)";
                } else if ($_POST['answertype'] == "date") {
                    $datatype = " DATE";
                } else {
                    $datatype = " INT";
                }

                if ($tagcountarray[0] == 0) {
                    $sql = "ALTER TABLE answers ADD " . $_POST["tag"] . $datatype; // writes a new column if the tag is not used before
                    $conn->query($sql);
                } else {
                    echo "This tag already exists, pick a new one";
                }
            }
            $conn -> close();
        ?>
    </div>

    <?php include "footer.html";?>
</body>
</html>