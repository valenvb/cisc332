<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'parts/menu.php';

    if(isset($_POST["inputUsername"]) && isset($_POST["inputEmail"]) &&
        isset($_POST["inputPassword"])) && isset($_POST["inputPassword2"]) &&
        isset($_POST["inputFName"]) && isset($_POST["inputLName"]) &&
        isset($_POST["inputAddress"]) && isset($_POST["inputPhone"]) &&
        isset($_POST["inputCreditNo"]) && isset($_POST["inputCreditExp"])){

            

        }

?>
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
    <form class="form-signin" action="newUser.php" method="POST">
        <img class="mb-4" src="css/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">New User</h1>
        <label for="inputUsername" class="sr-only">Username</label>
        <input id="inputUsername" class="form-control" placeholder="Username" required="" autofocus="" type="text">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" type="email">
        <label for="inputPassword" class="sr-only">Password</label>
        <input id="inputPassword" class="form-control" placeholder="Password" required="" type="password">
        <label for="inputPassword2" class="sr-only">Confirm Password</label>
        <input id="inputPassword2" class="form-control" placeholder=" Confirm Password" required="" type="password">
        <label for="inputFName" class="sr-only">First Name</label>
        <input id="inputFName" class="form-control" placeholder="First Name" required="" autofocus="" type="text">
        <label for="inputLName" class="sr-only">Last Name</label>
        <input id="inputLName" class="form-control" placeholder="Last Name" required="" autofocus="" type="text">
        <label for="inputAddress" class="sr-only">Address</label>
        <input id="inputAddress" class="form-control" placeholder="Address" autofocus="" type="text">
        <label for="inputPhone" class="sr-only">Phone</label>
        <input id="inputPhone" class="form-control" placeholder="Phone" autofocus="" type="tel">
        <label for="inputCreditNo" class="sr-only">Credit Card Number</label>
        <input id="inputCreditNo" class="form-control" placeholder="Credit Card Number" required="" autofocus="" type="number">
        <label for="inputCreditExp" class="sr-only">Credit Card Expiry</label>
        <input id="inputCreditExp" class="form-control" placeholder="Credit Card Expiry" required="" autofocus="" type="number">
        
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
    </form>
</body>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.min.js"></script>
</html>