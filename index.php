<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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

    <title>OMTS</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/album.css" rel="stylesheet">
  </head>

  <body>

    <?php 
    include 'parts/menu.php'; 
    include 'lib/database.php';
    

    $movies = $db->query("Select movieid, title, runtime, rating, plot, sdate from movie order by sdate DESC")->fetchAll();
    
    ?>

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading"><?php echo $movies[0]['title'];?></h1>
          <p class="lead text-muted"><?php echo $movies[0]['plot'];?></p>
          <p>
            <a href="reserve.php?movie_id=<?php echo $movies[0]['movieid'];?>" class="btn btn-primary my-2">Reserve Tickets</a>
            <a href="details.php?movie_id=<?php echo $movies[0]['movieid'];?>" class="btn btn-secondary my-2">Details</a>
          </p>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            <?php for ($i=1;$i<count($movies);) : ?>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=<?php echo $movies[$i]['title']?>" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text"><?php echo $movies[$i]['plot']; ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a type="button" href="reserve.php?movie_id=<?php echo $movies[$i]['movieid'];?>" class="btn btn-sm btn-outline-primary">Reserve</a>
                      <a type="button" href="details.php?movie_id=<?php echo $movies[$i]['movieid'];?>" class="btn btn-sm btn-outline-secondary">Details</a>
                    </div>
                    <small class="text-muted"><?php echo $movies[$i]['runtime']?> mins</small>
                  </div>
                </div>
              </div>
            </div>

            <?php $i+=1; endfor; ?>
          </div> <!--ROW-->
        </div>
      </div> 

    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Back to top</a>
        </p>
        <p> &copy; OMTS</p>
  
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.min.js"></script>
  </body>
</html>
