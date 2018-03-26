<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if( !isset($_SESSION['logged_in']) || (isset($_SESSION['logged_in']) && !$_SESSION['logged_in']) ) {
  
  header('Location:login.php');
}

include 'lib/database.php';


if(isset($_POST["movie_id"])){
  //do da shit in da DB
  $userID = $_SESSION["user_id"];
  $movie_id=$_POST["movie_id"];
  $when=$_POST["date"];
  $where=$_POST["where"];
  $startTime = str_replace("-", ":",$_POST["where"]);
  $qty = $_POST["quantity"];

  $remain = $db->query("SELECT Seats-`BookedSeats` as remain from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movie_id." AND C.ComplexNo=".$where." AND S.SDate=".$when." AND S.STime=".$startTime)->fetchColumn()[0];

  if($qty<$remain){
    print("SEATS NOT AVAIABLE");
  } else {

    $insertString = "INSERT INTO Reservation (UserID, STime, SDate, TheaterNo, ComplexNo, MovieID, NumTickets) VALUES (".$userID.", ".$startTime.", ".$when.", 2, ".$where.", ".$movie_id.", ".$qty.")";

    if($db->query($insertString)==TRUE){
      print("ADDED!");
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

//$showsQuery = $db->query("select S.`MovieID`, S.`TheaterNo`, S.`STime`, S.`SDate`, S.`ComplexNo`, `BookedSeats`, `Name`, `Address`, `Seats` from showing S, complex C, theater T where S.`TheaterNo`=T.`TheaterNo` and S.`ComplexNo`=T.`ComplexNo` and S.`ComplexNo`=C.`ComplexNo` and movieid=".$movieID);


//print_r($shows);

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
                
                  <select name="date" onchange="formProgress();" class="form-control" id="complex-select">
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
                
                  <select name="where" onchange="formProgress();" class="form-control" id="complex-select">
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

              while($show = $showsQuery->fetch()){
                echo " <label class=\"btn btn-secondary active\">
                <input type=\"radio\" name=\"showTime\" value=\"".str_replace(":", "-", $show['STime'])."\" id=\"".$show['STime']."\"> ".$show['STime']."</label> ";
              } ?>
            </div>


            
          </div>
          
          <h4 class="mb-3">How Many Tickets?</h4>
          <div class="row">
            <div class="col-md-6">
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
