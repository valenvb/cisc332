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

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

  <body>
    <?php include '../parts/menu.php'?>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#top">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                  Orders
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                  Products
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#cust_list">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                  Integrations
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main id="top" role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          
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
            <h1 class="h2">Showings</h1>
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
$shows = $db->query("select M.title, C.`name`, S.STIME, S.SDATE, theaterno from showing S, movie M, complex C where S.complexNo=C.complexNo and S.movieID=M.movieid");
//print($users->queryString);
while($show = $shows->fetch()){
  echo "<tr><td>".$show['title']."</td><td>".$show["name"]."</td><td>".$show["theaterno"]."</td><td>".$show["STIME"]."</td><td>".$show["SDATE"]."</td><td><a href=\"actions.php?action=ds&title=".$show['title']."&name=".$show['name']."&stime=".$show['STIME']."&sdate=".$show['SDATE']."\" class=\"btn btn-danger\">Delete</a></td></tr>";
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