<?php 

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if( !isset($_SESSION['logged_in']) || (isset($_SESSION['logged_in']) && !$_SESSION['logged_in'] )  ) {
  
  header('Location:login.php');
}
if ( $_SESSION['user_type'] != "A" ){

  header("Location:../index.php");
}

$complexData = null;
$complexNo = null;
include_once '../lib/database.php';

if(isset($_GET['complexno'])){
    $complexNo = $_GET['complexno'];

    $complexData = $db->query("SELECT * FROM complex where complexNo=".$complexNo)->fetch();
} else {
    $complexData = $db->query("SELECT * FROM complex")->fetch();
    $complexNo = $complexData['ComplexNo'];

}

?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OMTS Theater Complex Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

  <body>
    <?php include '../parts/menu.php'?>

    <div class="container-fluid">
      <div class="row">
        <?php include 'admin-menu.php'?>

        <main id="top" role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        
        <div class="row">
            <div class="col-md9">
                <h1 style="display:inline;" class="">Manage Complex: </h1>
                <form action="complex.php" method="GET" class="form-inline">
                    <select name="complexno" class="custom-select">

                        <?php 
                $cmplxs = $db->query("select name, complexNo from complex");
                while($cmplx=$cmplxs->fetch()){
                  echo"<option value='".$cmplx['complexNo']."' ".($complexNo==$cmplx['complexNo']? "selected":"")."  >".$cmplx['name']."</option>";
                }
              ?>

                    </select>
                    <button type=submit class="btn btn-primary">Go</button>
                </form>
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addComplexModal" > Add Complex</button>
                <a href="actions.php?action=dcomp&cno=<?php echo $complexNo; ?>" class="btn btn-sm btn-outline-danger">Delete Complex</a>
            </div>
        </div>
        <hr>


        <div id="theater_list">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <h1 class="h2">Theaters</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addTheaterModal" > Add</button>
              </div>

            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Theater No.</th>
                  <th>Seats</th>
                  <th>Screen Size</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
<?php 

include_once '../lib/database.php';
$theaters = $db->query('SELECT * from theater where ComplexNo='.$complexNo);

while($theater = $theaters->fetch()){
  echo "<tr><td>".$theater['TheaterNo']."</td><td>".$theater["Seats"]."</td><td>".$theater["Screen"]."</td><td> <a class=\"btn btn-danger\" href=\"actions.php?action=dt&tno=".$theater['TheaterNo']."&cno=".$theater['ComplexNo']."\">Delete</a></td></tr>";
};

?>              
                
              </tbody>
            </table>
          </div>
          </div> <!--END Theater TABLE-->



          <div id="show_list">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 ">
            <h1 class="h2">Upcoming Showings at this complex</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addShowingModal"> Add</button>
              </div>

            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Movie</th>
                  <th>Theater</th>
                  <th>Time</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
<?php 

include_once '../lib/database.php';
$shows = $db->query("select M.movieID, M.title, C.`name`, C.ComplexNo, S.STIME, S.SDATE, theaterno from showing S, movie M, complex C where S.complexNo=C.complexNo and S.movieID=M.movieid and S.sdate > CURRENT_DATE() and C.ComplexNo=".$complexNo);
//print($users->queryString);
while($show = $shows->fetch()){
  echo "<tr><td>".$show['title']."</td><td>".$show["theaterno"]."</td><td>".$show["STIME"]."</td><td>".$show["SDATE"]."</td><td><a href=\"actions.php?action=ds&title=".$show['movieID']."&name=".$show['ComplexNo']."&stime=".$show['STIME']."&sdate=".$show['SDATE']."\" class=\"btn btn-danger\">Delete</a></td></tr>";
};

?>              
                
              </tbody>
            </table>
          </div>
          </div> <!--END show TABLE-->


        </main>
      </div>
    </div>

<div class="modal  fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Customer Reservations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="modalIframe" src="" frameborder="0" style="width:100%;"></iframe>
      </div>
    </div>
  </div>
</div>
    

<div class="modal  fade" id="addComplexModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a Complex</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="actions.php?action=addComplex" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input name="name" class="form-control" type="text">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input name="address" class="form-control" type="text">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input name="phone" class="form-control" type="phone">
        </div>
    

        <button class="btn btn-primary right" type="submit">Add</button>

        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal  fade" id="addShowingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a Showtime</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="actions.php?action=addShow" method="POST">
        <div class="form-group">
            <label for="title">Movie</label>
            <select name="title" class="custom-select" type="text">

              <?php 
                $mvs = $db->query("select title, movieid from movie");
                while($mv=$mvs->fetch()){
                  echo"<option value='".$mv['movieid']."'>".$mv['title']."</option>";
                }
              ?>

            </select>
        </div>

        <div class="form-row">

          <div class="col form-group">
            <label for="where">Complex</label>
            <select disabled name="where" class="custom-select" type="text">

              <?php 
                $cmplxs = $db->query("select name, complexNo from complex");
                while($cmplx=$cmplxs->fetch()){
                  echo"<option value='".$cmplx['complexNo']."' ".($cmplx['complexNo']===$complexNo ? "selected" : "")." >".$cmplx['name']."</option>";
                }
              ?>

            </select>
          </div>
          <div class="col form-group">
              <label for="whereT">Theater No.</label>
              <select name="whereT" class="custom-select" type="text">
              <?php 
                $theaters = $db->query("select * from theater where complexNo=".$complexNo);
                while($t=$theaters->fetch()){
                  echo"<option value='".$t['theaterNo']."'  >".$t['TheaterNo']." (".$t["Screen"].", ".$t["Seats"].")</option>";
                }
              ?>

              </select>
          </div>
              
        </div>

        <div class="form-row">
          <div class="col form-group">
              <label for="sdate">Date</label>
              <input name="sdate" class="form-control" type="date">
          </div>
          <div class="col form-group">
              <label for="stime">Time</label>
              <input name="stime" class="form-control" type="time">
          </div>
        </div>

        <button class="btn btn-primary right" type="submit">Add</button>

        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal  fade" id="addTheaterModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="actions.php?action=addTheater" method="POST">
            <input hidden name="complexNo" value="<?php echo $complexNo;?>" type="text">
          <div class="form-group">
            <label for="tno">Theater Number</label>
            <input name="tno" min=0 class="form-control" type="number">
          </div>
          
          <div class="form-group">
            <label for="size">Capacity</label>
            <input name="size" min=0 class="form-control" type="number">
          </div>


        <div class="form-group">
            <label for="screen">Scree Size</label>
            <select name="screen" class="custom-select form-control">
              <option>S</option>
              <option>M</option>
              <option>L</option>
            </select>
          </div>

          <button class="btn btn-primary right" type="submit">Add</button>
        </form>
      </div>
    </div>
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
      feather.replace();

      function showIFrame(uri){
        console.log(uri)
        $('#modalIframe').attr('src',uri);
        $('#iframeModal').modal('show');
      }
    </script>
  

</body></html>