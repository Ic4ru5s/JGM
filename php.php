<?php
    function URLParameterExtraction() {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')    // construct URL
            $url = "https://";   
        else  
            $url = "http://";
        $url.= $_SERVER['HTTP_HOST'];   
        $url.= $_SERVER['REQUEST_URI'];    

        $url_components = parse_url($url); // read URL
        parse_str($url_components['query'], $params);
        return $params["team"];
    };

    function login() {
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
        return $conn;
    }

    function sqlToArray($sql, $conn) {
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        return $row;
    }
?>