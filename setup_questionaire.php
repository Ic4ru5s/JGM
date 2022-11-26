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
            Answer type: <select name="answertype" id="answertype" onChange="unlockOption(this)">
                <option value="text">Tekstvak</option>
                <option value="radio">Radio button</option>
                <option value="date">Datum</option>
                <option value="integer">Getal</option>
                <option value="check">Checkbox</option>
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

                if (option === "radio" || option === "check") { //determine answertype
                    const element = document.createElement('div');
                    element.innerHTML = "Options:" + '<input type="text" name="option0">' + '<button type="button" onclick="addOption()">+</button>'; // adds the first line option input
                    optionlist.appendChild(element);
                    document.getElementById("optioncount").value = optioncounter
                }
            }

            function addOption() { // creates more input elements
                optioncounter += 1
                const element = document.createElement('div');
                element.innerHTML ='<p>' + optioncounter + '<input type="text" name="option' + optioncounter + '">';
                optionlist.appendChild(element);
                document.getElementById("optioncount").value = optioncounter
            }
        </script>

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

        while ($currentoption <= $_POST["optioncount"]) {
            $name = "option" . $currentoption;

            if ($_POST[$name] != "") {
                $optionlist = $optionlist . $_POST[$name] . "|";
            } 
            
            $currentoption++;
        } 


        if ($_POST["question"] != "" || $_POST["tag"] != "" || $_POST["answertype"] != "") { // prevents empty rows in table
                $sql = "INSERT INTO questions (question, tag, answertype, options) VALUES ('$_POST[question]', '$_POST[tag]', '$_POST[answertype]', '$optionlist')";

            if ($conn->query($sql) === TRUE) {
                //echo "Question creation succesful";
                } else {
                echo "Error creating question: " . $conn->error;
                }
        }
        ?>

        <br><button class="btn line_button_black float_right " style="margin-top:15px;" onclick="window.location.href='index.php'">Home</button>
    </div>

    <div> <!-- Question display panel --> 
        <?php
            $sql = "SELECT id, question, tag, options FROM questions";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    if ($row["options"] != NULL) {
                        $options = explode("|", $row["options"]);
                        $counter = 0;
                        while ($counter < count($options)) {
                            echo $options[$counter] . "<br>";
                            $counter++;
                        }
                    }

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