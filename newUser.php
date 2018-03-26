<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    include 'parts/safety.php';
    //initializing variables
    $error = "";
    $username = $password = $email = $name = $address = $phone = $creditNo = $creditExp = null;
    //Checking all fields are set, except address and phone, which are optional

    /*
    if(!isset($_POST["inputUsername"])){
        $error .= "Username not set <br>";
    }
    if(!isset($_POST["inputEmail"])){
        $error .= "Email not set <br>";
    }
    if(!isset($_POST["inputPassword"])){
        $error .= "Password not set <br>";
    }
    if(!isset($_POST["inputPassword2"])){
        $error .= "Password 2 not set <br>";
    }
    if(!isset($_POST["inputFName"])){
        $error .= "First Name not set <br>";
    }
    if(!isset($_POST["inputLName"])){
        $error .= "Last Name not set <br>";
    }
    if(!isset($_POST["inputCreditNo"])){
        $error .= "CreditNo not set <br>";
    }
    if(!isset($_POST["inputCreditExp"])){
        $error .= "CreditExp not set <br>";
    }
    */

    if(isset($_POST["inputUsername"]) && isset($_POST["inputEmail"]) &&
        isset($_POST["inputPassword"]) && isset($_POST["inputPassword2"]) &&
        isset($_POST["inputFName"]) && isset($_POST["inputLName"]) &&
        isset($_POST["inputCreditNo"]) && isset($_POST["inputCreditExp"])){

        $username = clean_input($_POST["inputUsername"]);
        $dbh = new PDO('mysql:host=localhost;dbname=OMTS', "test", "test");
        //echo("username:".$username."<br>");
        //echo($dbh->query("SELECT * FROM USERS;")-> queryString . "<br>");
        //foreach($dbh->query("SELECT * FROM USERS;") as $row){
        //    print_r($row);
        //}
        //echo "<br>";
        
        //Checking for errors

        //Checking username is unique
        $freeUser = $dbh->query("SELECT COUNT(*) FROM USERS WHERE Login = '$username' AND UserType = 'M'");
        //echo(gettype($freeUser));
        //echo($freeUser == false);
        //print_r($freeUser->queryString);
        //echo($freeUser -> fetchColumn()[0]);
        if($dbh->query("SELECT COUNT(*) FROM USERS WHERE Login = '$username' AND UserType = 'M'") -> fetchColumn()[0]){
            $error .= "Username already in use <br>";
        }

        //Checking for password equality
        if($_POST["inputPassword"] !== $_POST["inputPassword2"]){
            $error .= "Passwords not equal <br>";
        }
        if(strlen((string)$_POST["inputCreditNo"]) !== 16 ||  strlen((string)$_POST["inputCreditExp"]) !== 4){
            $error .= "Invalid Credit Card Credentials";
        }

        if($error){
            //echo($error);
        } else {
            //If there are no errors, we will set our variables
            $email = clean_input($_POST["inputEmail"]);
            $password = clean_input($_POST["inputPassword"]);
            $name = clean_input($_POST["inputFName"] ." ". $_POST["inputLName"]);
            if(isset($_POST["inputAddress"])){
                $address = clean_input($_POST["inputAddress"]);
            }
            if(isset($_POST["inputPhone"])){
                $phone = clean_input($_POST["inputPhone"]);
            }
            $creditNo = clean_input($_POST["inputCreditNo"]);
            $creditExp = clean_input($_POST["inputCreditExp"]);
//1248163264128256
            //echo("Inserting into database");
            $checkQuery = $dbh -> query("INSERT INTO USERS (Login, Password, UserType) VALUES ('".$username."','". $password."', 'M')");
            //echo $checkQuery->queryString;
            //echo "<br>";
            $userID = $dbh -> query("SELECT UserID from Users WHERE Login = '$username'") -> fetch()["UserID"];
            //print_r($userID);
            //echo "<br>";
            $sql = "INSERT INTO MEMBER VALUES ($userID,'$name','$address',$phone,'$email',$creditNo,$creditExp)";
            //echo $sql;
            //echo "<br>";
            $checkQuery = $dbh -> query($sql);
            //echo $checkQuery->queryString;
            
            //logging user in
            $_SESSION["logged_in"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $userID;
            $_SESSION["user_type"] = 'M';
            header("Location:index.php");
        }
    } else {
        //echo($error);
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OMTS New User</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <img class="mb-4" src="css/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">New User</h1>
        <label for="inputUsername" class="sr-only">Username</label>
        <input id="inputUsername" name = "inputUsername" class="form-control" placeholder="Username" required="" autofocus="" type="text">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input id="inputEmail" name = "inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" type="email">
        <label for="inputPassword" class="sr-only">Password</label>
        <input id="inputPassword" name = "inputPassword" class="form-control" placeholder="Password" required="" type="password">
        <label for="inputPassword2" class="sr-only">Confirm Password</label>
        <input id="inputPassword2" name = "inputPassword2" class="form-control" placeholder=" Confirm Password" required="" type="password">
        <label for="inputFName" class="sr-only">First Name</label>
        <input id="inputFName" name = "inputFName" class="form-control" placeholder="First Name" required="" autofocus="" type="text">
        <label for="inputLName" class="sr-only">Last Name</label>
        <input id="inputLName" name = "inputLName" class="form-control" placeholder="Last Name" required="" autofocus="" type="text">
        <label for="inputAddress" class="sr-only">Address</label>
        <input id="inputAddress" name = "inputAddress" class="form-control" placeholder="Address" autofocus="" type="text">
        <label for="inputPhone" class="sr-only">Phone</label>
        <input id="inputPhone" name = "inputPhone" class="form-control" placeholder="Phone" autofocus="" type="tel">
        <label for="inputCreditNo" class="sr-only">Credit Card Number</label>
        <input id="inputCreditNo" name = "inputCreditNo" class="form-control" placeholder="Credit Card Number" required="" autofocus="" type="number" size=16>
        <label for="inputCreditExp" class="sr-only">Credit Card Expiry</label>
        <input id="inputCreditExp" name = "inputCreditExp" class="form-control" placeholder="Credit Card Expiry" required="" autofocus="" type="number" size=4>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
    </form>
    <span class="error">* 
        <?php 
        //if(isset($_POST["newUserError"])){echo $_POST["newUserError"];}
        echo $error;
        ?>
        </span>
</body>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.min.js"></script>
</html>