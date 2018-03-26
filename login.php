<?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $past = $_SERVER["HTTP_REFERER"];
    //checking for logout
    if(isset($_GET["logout"]) && $_GET["logout"]=="0"){
      //echo "Logged out";
      $_SESSION["logged_in"] = false;
      session_destroy();
      header("Location:$past"); 
    }
    //check if already logged in
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] ){
      //echo"<a>you are already logged in</a>";
      header("Location:$past");
    //check if user is trying to log in
    } elseif(isset($_POST["username"]) && isset($_POST["password"])){

      //echo("<a>In login check</a><br>");
      //Connecting to database
      $dbh = new PDO('mysql:host=localhost;dbname=OMTS', "test", "test");
      //foreach($dbh->query("SELECT * FROM USERS;") as $test_row){
      //   print_r($test_row);
      //}
      //initializing variables
      $username = $password = "";
      $username = clean_input($_POST["username"]);
      $password = clean_input($_POST["password"]);


      //echo("<a>got password: $password and user: $username </a><br>");
      //echo("Query is : SELECT * FROM USERS WHERE Login = '$username' <br>");

      //Querying databases
      $rows = $dbh->query("SELECT * FROM Users WHERE Login = '$username'");
      //echo($rows -> queryString);

      //while($row = $rows->fetch()){
      //  echo("<a>Row is:</a><br>");
      //  print_r($row);
      //}
      if($rows){
          $row = $rows -> fetch();
          //print_r($row);
          //echo("Password typed is: $password, actual is ".$row["Password"]);
          if($row["Password"] == $password){
              //echo("<a>Checked values, and logged in</a>");
              $_SESSION["logged_in"] = true;
              $_SESSION["username"] = $username;
              $_SESSION["user_id"] = $row["UserID"];
              $_SESSION["user_type"] = $row["UserType"];
              header("Location:index.php");
          }
          else{
              echo("<a>Error: Incorrect password</a>");
          }
      } else{
          echo("<a>Error: Invalid Username</a>");
      }
    } else { //User has not yet tried to log in
      echo("");
    }

    //A little bit of safty
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return($data);
    }
    
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>
  <body>

    <main role="main">
      <div class="">
        <form class="text-center bg-dark form-signin text-light" action="login.php" method="POST">
          <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          <label for="inputuserName" class="sr-only">Username</label>
          <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus >
          <label for="inputPassword" class="sr-only">Password</label>
          <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
          <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        </form>
        <a href = "newUser.php">New Account</a>
      </div>
    </main>

  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.min.js"></script>
  </body>
</html>
