<!DOCTYPE html>
<html>
<?php
    $username = $password = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = mysqli_escape_string(clean_input($_POST["username"]));
        $password = mysqli_escape_string(clean_input($_POST["pass"]));
    }
    
    $dbh = new PDO('mysql:host=localhost;dbname=OMTS', "root", "");

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return($data);
    }
?>

<html>