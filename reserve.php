<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if( !isset($_SESSION['logged_in']) || (isset($_SESSION['logged_in']) && !$_SESSION['logged_in']) ) {
  header('Location:login.php');
}

include 'lib/database.php';
$ORDER_SUCCESS=null;

if(isset($_POST["movie_id"])){
  //print("GOT POST");
  //do da shit in da DB
  $userID = $_SESSION["user_id"];
  $movie_id=$_POST["movie_id"];
  $when=$_POST["date"];
  $where=$_POST["where"];
  $startTime = str_replace("-", ":",$_POST["showTime"]);
  $qty = $_POST["quantity"];

  //print($startTime);

  $remain = $db->query("SELECT Seats-`BookedSeats` as remain from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movie_id." AND C.ComplexNo=".$where." AND S.SDate='".$when."' AND S.STime='".$startTime."'")->fetchColumn()[0];

  if($qty<$remain){
    //print("SEATS NOT AVAIABLE");
    $ORDER_SUCCESS=-1;
  } else {

   
    
    $theatre = $db->query("Select T.TheaterNo from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movie_id." AND C.ComplexNo=".$where." AND S.SDate='".$when."' AND S.STime='".$startTime."'")->fetchColumn()[0];
    
    $insertString = "INSERT INTO Reservation (UserID, STime, SDate, TheaterNo, ComplexNo, MovieID, NumTickets) VALUES (".$userID.", '".$startTime."', '".$when."', ".$theatre.", ".$where.", ".$movie_id.", ".$qty.")";
    
    //print($insertString);
    if($db->query($insertString)){
      //print("ADDED!");

      $udQ = "UPDATE Showing Set Showing.bookedSeats= bookedseats+".$qty." where movieid=".$movie_id." AND ComplexNo=".$where." AND SDate='".$when."' AND STime='".$startTime."'";

      if($db->query($udQ)){
       // print("UPDATED!");
        $ORDER_SUCCESS=1;
      } else {print("UPDATE ERROR");
        $ORDER_SUCCESS=0;
      }

    } else {
     // print("ERR");
      $ORDER_SUCCESS=0;
    }

  }



}



$movieID = $_GET["movie_id"];
$when = (isset($_GET["date"]) ? $_GET["date"] : null);
$where = (isset($_GET["where"]) ? $_GET["where"] : null);


$movie = $db->query("SELECT * from movie where MovieID=".$movieID)->fetch(PDO::FETCH_ASSOC);
//echo $movie->queryString;
//$movie = $movies->fetch();

if(!isset($when)){
  $dates = $db->query("SELECT distinct * FROM showing S where movieid=".$movieID);
  if($db->query("SELECT distinct count(*) C from showing where movieid=".$movieID)->fetchColumn()[0]==1) {
    //echo"ONE ONLY";
    $when = $dates->fetch()["SDate"];
  }
}

if(isset($when)){

  $complexes = $db->query("SELECT distinct SDate, S.`ComplexNo`, `Name`, `Address` from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movieID." AND SDate='".$when."'");

  
  $complexCount = $db->query("select count(distinct C.ComplexNo) from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movieID." and SDate='".$when."'")->fetchColumn()[0];
  
  if($complexCount==1){
    $where = $complexes->fetch()["ComplexNo"];
  }
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

    <title>Reserve Seats</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

<?php if(isset($ORDER_SUCCESS) && $ORDER_SUCCESS==1){?>
  <div class="alert alert-success" role="alert">
  Your tickets are reserved! Go <a href="index.php">home</a>?
</div>
<?php } ?>

<?php if(isset($ORDER_SUCCESS) && $ORDER_SUCCESS==0){?>
  <div class="alert alert-danger" role="alert">
  Uh-oh, somthing went wrong with your order :( Please try again in a bit.
</div>
<?php } ?>

    <div class="container">
      <div class="py-5 text-center">
        <h2>Reserve Seats to <?php echo $movie['Title']?></h2>
      </div>

          <div class="col-md-12">
            <form class="needs-validation" method="POST" novalidate>
              <input name="movie_id" type="text" hidden value="<?php echo $movieID;?>"/>

              <h4 class="mb-3">Date</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                
                  <select name="date" onchange="formProgress();" class="form-control custom-select" id="complex-select">
                    <?php 
                      $Alldates = $db->query("SELECT DISTINCT SDate FROM showing S where movieid=".$movieID);
                      while ($date = $Alldates->fetch()) {
                        echo "<option ".(isset($_GET['date']) && $_GET['date']==$date['SDate'] ?   "selected=\"selected\"":"" )." value=".$date['SDate'].">".$date['SDate']."</option>";
                      }
                    ?>
                  </select>


                  <div class="invalid-feedback">
                    Select a date!.
                  </div>
                </div>
              
              </div>

              <?php if (isset($when)){ ?>

              <h4 class="mb-3">Where Do You Want To See The Movie</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                
                  <select name="where" onchange="formProgress();" class="form-control custom-select" id="complex-select">
                    <?php 
                    $complexes = $db->query("SELECT DISTINCT S.`ComplexNo`, `Name`, `Address` from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movieID." AND SDate='".$when."'");
                     // print($complexes->queryString);
                      while ($complex=$complexes->fetch()) {
                        echo "<option ".(isset($where) && $where==$complex['ComplexNo'] ?   "selected=\"selected\"":"" )." value=".$complex['ComplexNo'].">".$complex['Name']." (".$complex["Address"].")"."</option>";
                      }
                    ?>
                  </select>


                  <div class="invalid-feedback">
                    Select a theater complex.
                  </div>
                </div>
              
              </div>

          
          <?php } if(isset($where)){ ?>

          <h4 class="mb-3">Select a showtime</h4>
          <div class="d-block my-3">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
            
            <?php 
              $showsQuery = $db->query("SELECT S.`MovieID`, S.`TheaterNo`, S.`STime`, S.`SDate`,  `BookedSeats`, `Seats` from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and BookedSeats<Seats and movieid=".$movieID." AND C.ComplexNo=".$where);

              //print($showsQuery->queryString);
?>
              <select name="showTime" onchange="formProgress();" class="form-control custom-select" id="complex-select">
                <?php
              while($show = $showsQuery->fetch()){
                echo " 
                <option value=\"".str_replace(":", "-", $show['STime'])."\">".$show['STime']."</option>";
              } ?>
              </select>
            </div>


            
          </div>
          
          <h4 class="mb-3">How Many Tickets?</h4>
          <div class="row">
            <div class="col-md-6">
            <?php if(isset($ORDER_SUCCESS) && $ORDER_SUCCESS==-1){?>
            <div class="alert alert-warning" role="alert">
               Sorry, we don't have that many tickets available at the moment.
            </div>
            <?php } ?>
          <input class="form-control" min=0 id="quantity" name="quantity" type="number"></input>
          </div>
          </div>
<br>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Reserve Now!</button>

          <?php } ?>

            

            
            
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 OMTS</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      
        
      var movieID = <?php echo $movieID; ?>;

      function formProgress(){
        console.log("CALL")
        var cp = window.location.href;
        var getString = cp.split("?")[0]+"?movie_id="+movieID;
        $(".form-control").each(function() {
          getString+="&"+this.name+"="+this.value
        });

        window.location.href=getString;
   }
    </script>
  </body>
</html>
