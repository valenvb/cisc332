<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_GET["movie_id"])){
  header("Location: index.php");
}

include 'lib/database.php';
$thisMovie = $db->query("Select * from movie where movieid=".$_GET["movie_id"])->fetch();
$reviewSubmitted=null;

if(isset($_POST["score"])){
  //print("ADDING REVIEW");
  include_once 'parts/safety.php';
  $score = clean_input($_POST["score"]);
  $txt = clean_input($_POST["words"]);
  $usr = $_POST["user_id"];
  
  $insertString = "INSERT INTO Review (UserID, words, score, movieID) VALUES (".$usr.", \"".$txt."\", ".$score.", ".$thisMovie['MovieID'].")";

  $add = $db->prepare($insertString);

  if($add->execute()){
    $reviewSubmitted=TRUE;
  } else {
    $reviewSubmitted=FALSE;
    //print_r($add->errorInfo());
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

    <title><?php echo $thisMovie['Title'];  ?> - Movie Details</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>

    <?php include 'parts/menu.php'; ?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">
        <?php echo $thisMovie['Title'];  ?>
      </h1>
      <p>Directed By:
        <?php echo $thisMovie['Director']; ?>, Runtime:
        <?php echo $thisMovie['RunTime']; ?> minutes, Rated
        <?php echo $thisMovie['Rating']; ?> </p>
      <p>
        <a class="btn btn-primary btn-lg" href="reserve.php?movie_id=<?php echo $thisMovie['MovieID'];?>" role="button">Reserve Tickets &raquo;</a>
      </p>
    </div>
  </div>

  <div class="container">
    <!-- Example row of columns -->
    <div class="row">
      <div class="col-md-9">
        <h2>About</h2>
        <p>
          
          <?php echo $thisMovie['Plot'];?> </p>
      </div>
      <div class="col-md-3">
        <h2>Cast</h2>
        <ul class="list-group">
          <?php 
                  $cast = $db->query("Select CONCAT(FNAME, \" \", LNAME) as name from actors where MovieID=".$thisMovie['MovieID']);

                  while($actor=$cast->fetch()){
                    echo "<li class=\"list-group-item\" >".$actor['name']."</li>";
                  }

               ?>
        </ul>

      
      </div>

    </div>

    <div class="row">

      <div class="col-md-12">

<?php if(isset($reviewSubmitted) && $reviewSubmitted){?>
  <div class="alert alert-success" role="alert">
  Your Review has been added!
</div>
<?php } ?>
<?php if(isset($reviewSubmitted) && !$reviewSubmitted){?>
  <div class="alert alert-error" role="alert">
  Sorry, there was an error postign your review. Try again later.
</div>
<?php } ?>

        <hr>
        <h2>Reviews</h2>

        <?php
            $reviews = $db->query("select words, name, score from review R, users U, member M where R.`UserID`=U.`UserID` and U.`UserID`=M.userId and movieID=".$thisMovie['MovieID'])->fetchAll();
          
            if(count($reviews)===0){?>
              <h5 style="padding-left:10px;">No Reviews</h5>
           <?php }

            foreach($reviews as $review) :           
          ?>
              <div style="margin-bottom:1px;" class="col-md-9">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="display:inline;">
                    <?php echo $review['score']; ?>/5 </h4>
                    <?php echo $review['name'];?>
                    <hr>
                    <p><?php echo $review['words']; ?> </p>
                  </div .card-body>
                </div .card>
              </div .col>
              <br>
      <?php endforeach; ?>

      <div class="row">
      <div class="col-md-9">
      <h4>Add a review:</h4>
              <form action="details.php?movie_id=<?php echo $thisMovie["MovieID"]?>" method="POST">
                <input name="user_id" type="text" hidden class="hidden" value="<?php echo $_SESSION['user_id']?>">
                <div class="col-md-2">
                  <label class="" for="score">Score:</label>
                  <input name="score" min=0 max=5 type="number" class="form-control" required>
                </div>
                <br>
                <div class="col-md-12">
                  <textarea name="words" type="text" rows=4 class="form-control" required></textarea>
                  <br>
                  <button type="submit" class=" btn btn-primary">Submit</button>
                </div>
                
              </form>
      </div>
    
    </div>
    </div>
    <br>
    
    
  </div>

  <hr>

  </div> <!-- /container -->

</main>

    <footer class="container">
      <p>&copy; OMTS</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
