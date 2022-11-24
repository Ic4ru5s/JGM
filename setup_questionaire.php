<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionaire setup</title>
</head>
<body>
    <div> <!-- Question submission panel -->
        <form action="setup_questionaire.php" method="post"> <!-- Collect the data required to make question cards -->
            Question: <input type="text" name="question"><br>
            Tag: <input type="text" name="tag"><br>
            Answer type: <select name="answertype" id="answertype">
                <option value="radio">Radio button</option>
                <option value="text">Tekstvak</option>
                <option value="date">Datum</option>
                <option value="integer">Getal</option>
                <option value="check">Checkbox</option>
            </select><br>
            Options: <input type="text" name="option1"><br> <!-- Try to add more options with a button -->
            <input type="text" name="option2"><br>
            <input type="text" name="option3"><br>
            <input type="text" name="option4"><br>
            <input type="text" name="option5"><br>
            <input type="text" name="option6"><br>
            <input type="submit">
        </form>

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

        if ($_POST["question"] != NULL || $_POST["tag"] != NULL || $_POST["answertype"] != NULL) { // prevents empty rows in table
                $sql = "INSERT INTO questions (question, tag, answertype) VALUES ('$_POST[question]', '$_POST[tag]', '$_POST[answertype]')";

            if ($conn->query($sql) === TRUE) {
                echo "question creation succesful";
                } else {
                echo "Error creating table: " . $conn->error;
                }
        }
        ?>

        <br><button class="btn line_button_black float_right " style="margin-top:15px;" onclick="window.location.href='index.php'">Home</button>
    </div>

    <div> <!-- Question display panel -->
        <?php
            $sql = "SELECT id, question, tag FROM questions";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<br> id: ". $row["id"]. " - Name: ". $row["question"]. " " . $row["tag"] . "<br>";
                }
            } else {
                echo "0 results";
            }
            
            $conn->close();
        ?>
    </div>
</body>
</html>