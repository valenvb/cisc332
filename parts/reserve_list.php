<?php
include_once '../lib/database.php';
$user = $_GET["userID"];

$reserves=$db->query("Select M.title, NumTickets, R.Stime, R.Sdate, C.Name, R.theaterNo  from reservation R, users U, showing S, movie M, complex C where R.userid=U.userid and R.movieid=S.movieid and S.movieid=M.movieID and S.`ComplexNo`=C.complexno and R.userid=".$user);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="../css/bootstrap.css" rel="stylesheet">
    <title>Reservations</title>
</head>
<body>
<table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Movie</th>
                  <th>Number of seats</th>
                  <th>Start Time</th>
                  <th>Date</th>
                  <th>Complex</th>
                  <th>Theater Number</th>
                </tr>
              </thead>
              <tbody>
<?php 

while($res = $reserves->fetch()){
  echo "<tr><td>".$res['title']."</td><td>".$res["NumTickets"]."</td><td>".$res["Stime"]."</td><td>".$res["Sdate"]."</td><td>".$res["Name"]."</td><td>".$res["theaterNo"]."</td></tr>";
};

?>              
                
              </tbody>
            </table>
</body>
</html>