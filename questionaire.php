<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionaire</title>
</head>
<body>
    <form action="questionaire.php" method="post"> <!-- might change the action location -->
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

            $sql = "SELECT questions FROM questionaires WHERE id = 22"; //change the id to be dynamic
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            $rowtrim = rtrim($row[0], "|");

            $questions = explode("|", $rowtrim);
            $counter = 0;


            while($counter < count($questions)) {
                $questionid = intval($questions[$counter]);
                $sql = "SELECT question, tag, answertype, options FROM questions WHERE id = $questionid";
                $questinfo = $conn->query($sql);
                $questarray = mysqli_fetch_array($questinfo);

                echo "<div><h1>" . $questarray["question"] . "</h1><br>";
                
                if ($questarray["answertype"] === "radio" || $questarray["answertype"] === "checkbox") {
                    $optstring = $questarray["options"];
                    $opttrim = rtrim($optstring, "|");
                    $optarray = explode("|", $opttrim);
                    // insert for loop
                    foreach ($optarray as $option) {
                        echo '<input type="' . $questarray["answertype"] . '" id="' . $option . '" name="' . $questarray["tag"] . '" value="' . $option . '"><label for="' . $option . '">' . $option . '</label><br>';
                    }
                    
                } else {
                    echo '<input type="' . $questarray["answertype"] . '" name="' . $questarray["answertype"] . '">';
                }

                echo "</div>";

                $counter++;
            }
        ?>
    <input type="submit">
    </form>
</body>
</html>