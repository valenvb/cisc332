<?php
    session_start();
    $username = $password = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = mysqli_escape_string(clean_input($_POST["username"]));
        $password = mysqli_escape_string(clean_input($_POST["pass"]));
    }
    
    $dbh = new PDO('mysql:host=localhost;dbname=OMTS', "root", "");

    $rows = $dbh->query("SELECT * FROM USERS WHERE Login = $username");
    /*
    USERS [0] = UserID
    USERS [1] = LOGIN
    USERS [2] = PASSWORD
    USERS [3] = USERTYPE
    */
    define("USERID", 0);
    define("LOGIN", 1);
    define("PASSOWORD", 2);
    define("TYPE", 3);
    if($rows){
        if($rows[0][PASSWORD] == $password){
            $_SESSION["logged_in"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $rows[0][USERID];
            $_SESSION["user_type"] = $rows[0][TYPE];
        }
        else{
            echo("<a>Error: Incorrect password</a>");
        }
    }
    else{
        echo("<a>Error: Invalid Username</a>");
    }
    


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
    <?php include 'parts/menu.php'; ?>

    <main role="main">
      <div class="">
        <form class="text-center bg-dark form-signin text-light" action="login.php" method="POST">
          <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          <label for="inputuserName" class="sr-only">Username</label>
          <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required     autofocus>
          <label for="inputPassword" class="sr-only">Password</label>
          <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password"     required>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
          <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        </form>
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
