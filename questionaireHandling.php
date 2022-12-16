<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionaire completed</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php
        include "header.html";
        include "./idk/php.php"; 
        $conn = login();
    ?>

    <div class="headerblock"></div>
    <h1>De afsluitpagina</h1>
    <p>Op deze pagina wordt de vragenlijst verwerkt en de deelnemers bedankt. Deze pagina is niet relevant voor de deelnemers maar zorgt voor een betere dataflow van vragenlijst naar database.</p>


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
        $tags = "";
        $values = "";
        foreach($questions as $question) {
            //find the question and its info
            $questionid = intval($question);
            $sql = "SELECT question, tag, answertype, options FROM questions WHERE id = $questionid";
            $questinfo = $conn->query($sql);
            $questarray = mysqli_fetch_array($questinfo);
            $tag = $questarray['tag'];
            $tags = $tags . $tag . ", ";

            //determine how to read the question
            if ($questarray["answertype"] === "radio" || $questarray["answertype"] === "text" || $questarray["answertype"] === "date") {
                $values =  $values . "'" . $_POST[$tag] . "', ";
            } else if ($questarray["answertype"] === "number") {
                $values =  $values . $_POST[$tag] . ", ";
            } else {
                $value = "";
                foreach ($_POST[$tag] as $option) {  
                    $value = $value . $option . "|";
                }
                $value = rtrim($value, "|");
                $values = $values . "'" . $value . "', ";
            }
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
        $conn -> close();
        include "footer.html";
    ?>
    <script> // prevents resubmission when refreshing, might change for post-refresh-get if ample reason to
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>