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

?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>OMTS Admin Dashboard</title>

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
          
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
          </div>

        <div class="sats">
        <?php
          include_once '../lib/database.php';
    $mostPopularComplex = $db->query("Select `name`, C.complexno, num from complex C, (SELECT COMPLEXNO, NUM FROM (SELECT MAX(COUNTED) AS NUM FROM (SELECT COMPLEXNO, SUM(NUMTICKETS) AS COUNTED FROM RESERVATION GROUP BY COMPLEXNO) AS TICKETSUM) AS NUMS INNER JOIN (SELECT COMPLEXNO, SUM(NUMTICKETS) AS COUNTED FROM RESERVATION GROUP BY COMPLEXNO) AS NUMSS ON NUM = COUNTED) as R where c.complexno=R.complexno;")->fetch();

    $mostPopularMovie = $db->query("Select title, M.movieID, num from movie M, (SELECT MOVIEID, NUM FROM (SELECT MAX(COUNTED) AS NUM FROM (SELECT MOVIEID, SUM(NUMTICKETS) AS COUNTED FROM RESERVATION GROUP BY MOVIEID) AS TICKETSUM) AS NUMS INNER JOIN (SELECT MOVIEID, SUM(NUMTICKETS) AS COUNTED FROM RESERVATION GROUP BY MOVIEID) AS NUMSS ON NUM = COUNTED) as R where M.movieid=R.movieID;")->fetch();
  ?>
          <p>
            The most popular complex is: <a href="complex.php?complexno=<?php echo $mostPopularComplex['complexno']; ?>"><?php echo $mostPopularComplex['name'];?></a>. It has sold <?php echo $mostPopularComplex['num']?> tickets.
          </p>
          <p>
            The most popular movie is: <a href="../details.php?movie_id=<?php echo $mostPopularMovie['movieID']; ?>"><?php echo $mostPopularMovie['title'];?></a>. It has sold <?php echo $mostPopularMovie['num']?> tickets.
          </p>
        </div>


        <div id="mov_list">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <h1 class="h2">Movies</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#addMovieModal" > Add</button>
              </div>

            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Runtime</th>
                  <th>Rating</th>
                  <th>Release Date</th>
                  
                </tr>
              </thead>
              <tbody>
<?php 

include_once '../lib/database.php';
$movies = $db->query('SELECT * from Movie');

while($movie = $movies->fetch()){
  echo "<tr><td>".$movie['MovieID']."</td><td>".$movie["Title"]."</td><td>".$movie["RunTime"]."</td><td>".$movie["Rating"]."</td><td>".$movie["SDate"]."</td></tr>";
};

?>              
                
              </tbody>
            </table>
          </div>
          </div> <!--END MOVIE TABLE-->



          <div id="show_list">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 ">
            <h1 class="h2">Upcoming Showings</h1>
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
                  <th>Complex</th>
                  <th>Theater</th>
                  <th>Time</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
<?php 

include_once '../lib/database.php';
$shows = $db->query("select M.movieID, M.title, C.`name`, C.ComplexNo, S.STIME, S.SDATE, theaterno from showing S, movie M, complex C where S.complexNo=C.complexNo and S.movieID=M.movieid and S.sdate > CURRENT_DATE()");
//print($users->queryString);
while($show = $shows->fetch()){
  echo "<tr><td>".$show['title']."</td><td>".$show["name"]."</td><td>".$show["theaterno"]."</td><td>".$show["STIME"]."</td><td>".$show["SDATE"]."</td><td><a href=\"actions.php?action=ds&title=".$show['movieID']."&name=".$show['ComplexNo']."&stime=".$show['STIME']."&sdate=".$show['SDATE']."\" class=\"btn btn-danger\">Delete</a></td></tr>";
};

?>              
                
              </tbody>
            </table>
          </div>
          </div> <!--END show TABLE-->


          <div id="cust_list">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 ">
            <h1 class="h2">Customers</h1>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
<?php 

include_once '../lib/database.php';
$users = $db->query("SELECT * from Users, Member where Users.userid=member.userid");
//print($users->queryString);
while($user = $users->fetch()){
  echo "<tr><td>".$user['UserID']."</td><td>".$user["Name"]."</td><td>".$user["Email"]."</td><td>".$user["Phone"]."</td><td>".$user["UserType"]."</td><td><button onclick=\"showIFrame('../parts/reserve_list.php?userID=".$user['UserID']."')\" class=\"btn btn-primary\">Reservations</button><a href=\"actions.php?action=dm&id=".$user['UserID']."\" class=\"btn btn-danger\">Delete</a></td></tr>";
};

?>              
                
              </tbody>
            </table>
          </div>
          </div> <!--END User TABLE-->




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
            <select name="where" class="custom-select" type="text">

              <?php 
                $cmplxs = $db->query("select name, complexNo from complex");
                while($cmplx=$cmplxs->fetch()){
                  echo"<option value='".$cmplx['complexNo']."'>".$cmplx['name']."</option>";
                }
              ?>

            </select>
          </div>
          <div class="col form-group">
              <label for="whereT">Theater No.</label>
              <input name="whereT" min=0 class="form-control" type="text">
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

<div class="modal  fade" id="addMovieModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="actions.php?action=add" method="POST">
          <div class="form-group">
            <label for="title">Movie Title</label>
            <input name="title" class="form-control" type="text">
          </div>
          <div class="form-group">
            <label for="director">Director</label>
            <input name="director" class="form-control" type="text">
          </div>

          <div class="form-group">
            <label for="plot">Plot</label>
            <textarea name="plot" rows=2 class="form-control" type="text"></textarea>
          </div>

          <div class="form-row">
          <div class="col form-group">
            <label for="runtime">Runtime</label>
            <input name="runtime" min=0 class="form-control" type="number">
          </div>
          <div class="col form-group">
            <label for="rating">Rating</label>
            <select name="rating" class="custom-select form-control">
              <option>G</option>
              <option>PG</option>
              <option>14A</option>
              <option>18A</option>
              <option>A</option>
              <option>R</option>
            </select>
          </div>
          </div>

          <div class="form-group">
            <label for="producer">Producer</label>
            <input name="producer" class="form-control" type="text">
          </div>

          <div class="form-row">
          <div class="col form-group">
            <label for="sdate">Start Date</label>
            <input name="sdate" class="form-control" type="date">
          </div>
          <div class="col form-group">
            <label for="edate">End Date</label>
            <input name="edate" class="form-control" type="date">
          </div>
          </div>

          <div class="form-group">
            <label for="supplier">Supplier</label>
            <select name="supplier" class="custom-select form-control">
              <?php 
                $suppliers = $db->query("select `Name`, supplierid as id  from supplier");

                while($sup=$suppliers->fetch()){
                  echo"<option value='".$sup['id']."'>".$sup['Name']."</option>";
                }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="cast">Cast</label><br>
            <small class"form-text text-muted">Each on a new line</small>
            <textarea name="cast" rows=2 class="form-control" type="text"></textarea>
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