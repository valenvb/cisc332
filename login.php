<?php
    $username = $password = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = mysqli_escape_string(clean_input($_POST["username"]));
        $password = mysqli_escape_string(clean_input($_POST["pass"]));
    }
    
    $link = mysqli_connect("localhost", "root", "", "OMTS");

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return($data);
    }
?>