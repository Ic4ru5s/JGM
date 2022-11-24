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

    // sql to create table
    $sql = "INSERT INTO questions (question, tag, answertype) VALUES ('$_POST[question]', '$_POST[tag]', '$_POST[answertype]')"; // this line is broken

    if ($conn->query($sql) === TRUE) {
        echo "question creation succesful";
        } else {
        echo "Error creating table: " . $conn->error;
        }
        
        $conn->close();
    ?>