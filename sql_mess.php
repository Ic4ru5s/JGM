<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>


$options = array($_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4'], $_POST['option5'], $_POST['option6']); // should ignore empty options eventually



<form action="setup_questionaire.php" method="post" id="options">
        Options:
    </form>

$options = "array(" $_POST['option1'] ", " $_POST['option2'] ", " $_POST['option3'] ", " $_POST['option4'] ", " $_POST['option5']", " $_POST['option6'] ")"; // should ignore empty options eventually
    echo $options;

<script>
        const options = document.getElementById("options")

        function addOption() {
            const textbox = document.createElement('input');
            textbox.type = 'text';
            options.appendChild(textbox);
        }
    </script>

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

if ($row["options"] != NULL) {
    $options = explode("|", $row["options"]);
    $counter = 0;
    while ($counter < count($options)) {
    $optionstring = $optionstring . $counter "<br>";
    $counter++;
    }
}       

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);