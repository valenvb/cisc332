<?php
      if (session_status() == PHP_SESSION_NONE) {
    session_start();
	}
	  $dbh = new PDO('mysql:host=localhost;dbname=OMTS', "root", "");  
	  
      //Querying databases
      $rows = $dbh->query("SELECT * FROM 'movie'");
      echo($rows -> queryString);
	  
      if($rows){
          $row = $rows -> fetch();
          print_r($row);

?>