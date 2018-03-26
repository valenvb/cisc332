<?php
include '../lib/database.php';
include '../parts/menu.php';
$userID = $username = $password = $email = $name = $address = $phone = $creditNo = $creditExp = null;

$info = $db -> query("SELECT * FROM USERS WHERE UserID = ".$_SESSION["user_id"]) -> fetch();
$userID = $_SESSION["user_id"];
$username = $info["Login"];
$password = $info["Password"];
$info = $db -> query("SELECT * FROM MEMBER WHERE UserID =".$_SESSION["user_id"]) -> fetch();
print_r($info);
$email = $info["Email"];
$name = $info["Name"];
$address = $info["Address"];
$phone = $info["Phone"];
$creditNo = $info["CreditNo"];
$creditExp = $info["CreditExp"];


?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  <style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style></head>

  <body>
  <!--Navbar-->
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                  History
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                  Purchases
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          <?php
          
          $error = "";
          if(isset($_POST["inputUsername"]) && isset($_POST["inputEmail"]) &&
          isset($_POST["inputPassword"]) && isset($_POST["inputPassword2"]) &&
          isset($_POST["inputFName"]) && isset($_POST["inputLName"]) &&
          isset($_POST["inputCreditNo"]) && isset($_POST["inputCreditExp"])){
  
          $username = clean_input($_POST["inputUsername"]);
          //echo("username:".$username."<br>");
          //echo($db->query("SELECT * FROM USERS;")-> queryString . "<br>");
          //foreach($db->query("SELECT * FROM USERS;") as $row){
          //    print_r($row);
          //}
          //echo "<br>";
          
          //Checking for errors
  
          //Checking username is unique
          $freeUser = $db->query("SELECT COUNT(*) FROM USERS WHERE Login = '$username' AND UserType = 'M'");
          //echo(gettype($freeUser));
          //echo($freeUser == false);
          //print_r($freeUser->queryString);
          //echo($freeUser -> fetchColumn()[0]);
          if($db->query("SELECT COUNT(*) FROM USERS WHERE Login = '$username' AND UserType = 'M'") -> fetchColumn()[0]){
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
              echo($error);
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
              
              $db -> query("DELETE FROM MEMBER WHERE UserID = '$userID'");
              $db -> query("DELETE FROM USERS WHERE UserID = '$userID'");
              //echo("Inserting into database");
              $db -> query("INSERT INTO USERS (Login, Password, UserType) VALUES ($userID,'".$username."','". $password."', 'M')");
              //echo $checkQuery->queryString;
              //echo "<br>";
              $userID = $db -> query("SELECT UserID from Users WHERE Login = '$username'") -> fetch()["UserID"];
              //print_r($userID);
              //echo "<br>";
              $sql = "INSERT INTO MEMBER VALUES ($userID,'$name','$address',$phone,'$email',$creditNo,$creditExp)";
              //echo $sql;
              //echo "<br>";
              $checkQuery = $db -> query($sql);
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
  <body>
      <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <h1 class="h3 mb-3 font-weight-normal">Edit User</h1>
          <label for="inputUsername" class="sr-only">Username</label>
          <input id="inputUsername" name = "inputUsername" class="form-control" placeholder="Username" required="" autofocus="" type="text" value = <?php echo($username);?>>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input id="inputEmail" name = "inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" type="email" value = <?php echo($email);?>>
          <label for="inputPassword" class="sr-only">Password</label>
          <input id="inputPassword" name = "inputPassword" class="form-control" placeholder="Password" required="" type="password" value = <?php echo($password);?>>
          <label for="inputPassword2" class="sr-only">Confirm Password</label>
          <input id="inputPassword2" name = "inputPassword2" class="form-control" placeholder=" Confirm Password" required="" type="password" value = <?php echo($password);?>>
          <label for="inputFName" class="sr-only">Name</label>
          <input id="inputFName" name = "inputFName" class="form-control" placeholder="Name" required="" autofocus="" type="text" value = <?php echo($name);?>>
          <label for="inputAddress" class="sr-only">Address</label>
          <input id="inputAddress" name = "inputAddress" class="form-control" placeholder="Address" autofocus="" type="text" value = <?php echo($address);?>>
          <label for="inputPhone" class="sr-only">Phone</label>
          <input id="inputPhone" name = "inputPhone" class="form-control" placeholder="Phone" autofocus="" type="tel">
          <label for="inputCreditNo" class="sr-only">Credit Card Number</label>
          <input id="inputCreditNo" name = "inputCreditNo" class="form-control" placeholder="Credit Card Number" required="" autofocus="" type="number" size=16 value = <?php echo($creditNo);?>>
          <label for="inputCreditExp" class="sr-only">Credit Card Expiry</label>
          <input id="inputCreditExp" name = "inputCreditExp" class="form-control" placeholder="Credit Card Expiry" required="" autofocus="" type="number" size=4 value = <?php echo($creditExp);?>>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
        <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
      </form>
      <span class="error">* 
          <?php 
          //if(isset($_POST["newUserError"])){echo $_POST["newUserError"];}
          echo $error;
          ?>
          </span>
        </body>
  
        </main>
      </div>
    </div>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.js"></script>

    <!-- Icons -->
    <script src="../js/feather.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="index_files/Chart.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
  

</body></html>