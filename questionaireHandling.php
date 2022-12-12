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

include "./idk/php.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionaire completed</title>
</head>
<body>
    <?php
        //find the questions answered
        $teamid = URLParameterExtraction();
        $sql = "SELECT vragenId FROM companies WHERE id = '$teamid'";
        $vragenIds = $conn->query($sql);
        $row = mysqli_fetch_array($vragenIds);

        $sql = "SELECT questions FROM questionaires WHERE id = '$row[vragenId]'";
        $result = $conn->query($sql);
        $row1 = mysqli_fetch_array($result);
        $rowtrim = rtrim($row1[0], "|");
        $questions = explode("|", $rowtrim);

        //loop through questions
        $counter = 0;
        $tags = "";
        $values = "";
        while($counter < count($questions)) {
            //find the question and its info
            $questionid = intval($questions[$counter]);
            $sql = "SELECT question, tag, answertype, options FROM questions WHERE id = $questionid";
            $questinfo = $conn->query($sql);
            $questarray = mysqli_fetch_array($questinfo);
            $tag = $questarray['tag'];
            $tags = $tags . $tag . ", ";

            //determine how to read the question
            if ($questarray["answertype"] === "radio" || $questarray["answertype"] === "text") {
                $values =  $values . "'" . $_POST[$tag] . "', ";
            } else if ($questarray["answertype"] === "date" || $questarray["answertype"] === "number") {
                $values =  $values . $_POST[$tag] . ", ";
            } else {
                $value = "";
                foreach ($_POST[$tag] as $option) {  
                    $value = $value . $option . "|";
                }
                $value = rtrim($value, "|");
                $values = $values . "'" . $value . "', ";
            }
            $counter++;
        }
        $values = rtrim($values, ", ");
        $tags = rtrim($tags, ", ");

        // build the sql query
        $sql = "INSERT INTO answers (teamid, " . $tags . ") VALUES (" . $teamid . ", " . $values . ")";
        if ($conn->query($sql) !== TRUE) {
            echo "Error while uploding answers: " . $conn->error;
        } else {
            echo "Bedankt voor het invullen van deze vragenlijst.";
        }
    ?>
</body>
</html>