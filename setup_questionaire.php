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

$currentoption = 0;
$optionlist = "";       

if (!empty($_POST["answertype"])) {
    while ($currentoption <= $_POST["optioncount"]) {
    $name = "option" . $currentoption;
        if ($_POST[$name] != "") {
            $optionlist = $optionlist . $_POST[$name] . "|";
        }       
    $currentoption++;
    } 
}

if (!empty($_POST["question"]) && !empty($_POST["tag"]) && !empty($_POST["answertype"])) { // prevents empty rows in table
    $sql = "INSERT INTO questions (question, tag, answertype, options) VALUES ('$_POST[question]', '$_POST[tag]', '$_POST[answertype]', '$optionlist')";

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
</head>
<body>
    <div>  <!-- Question display panel -->
        <form action="new_report.php" method="post"> 
            <input type="text" name="questionaireTitle"><br>
            <?php
                $sql = "SELECT id, question, tag, options FROM questions";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo $row["question"] . '<input type="checkbox" name="selector' . $row["id"] . '" onclick="selection(' . $row["id"] . ')" id=' . $row["id"] . '><br>'; //add the delete and change order buttons
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
            Question: <input type="text" name="question"><br>
            Tag: <input type="text" name="tag"><br>
            Answer type: <select name="answertype" id="answertype" onChange="unlockOption(this)">
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
                    optionlist.innerHTML += "Options: <br>" + '<input type="text" name="option0" id="option0">' + '<button type="button" onclick="addOption()">+</button>'; // adds the first line option input
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
                $tagcount = $conn->query($sql);
                $tagcountarray = mysqli_fetch_array($tagcount);
                if ($tagcountarray[0] == 0) {
                    $sql = "ALTER TABLE answers ADD " . $_POST["tag"] . " VARCHAR(255)"; // writes a new column if the tag is not used before
                    $conn->query($sql);
                } else {
                    echo "This tag already exists, pick a new one";
                }
            }
        ?>
        <br><button onclick="window.location.href='index.php'">Home</button>
    </div>

    <script> // prevents resubmission when refreshing, might change for post-refresh-get if ample reason to
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</body>
</html>