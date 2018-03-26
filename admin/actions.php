<?php
include_once '../lib/database.php';
include_once '../parts/safety.php';
if(!isset($_GET["action"])){
    print("NO ACTION");
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

$action = $_GET['action'];

if($action=="dm"){ //delete member
    $id = $_GET["id"];
    $del = $db->prepare("Delete from members, users where userID=".$id);

    if($del->execute()){
        //print("DELETED");
    } else {
        print_r($del->errorInfo());
    }
}

if($action=="ds"){ //delete showing
    $title = $_GET["title"];
    $where = $_GET["name"];
    $time = clean_input($_GET["stime"]);
    $date = clean_input($_GET["sdate"]);

    $del = $db->prepare("Delete from showing where movieID=".$title." and complexNo=".$where." and STime='".$time."' and Sdate='".$date."'");

    //print_r($del->queryString);

    if($del->execute()){
        //print("DELETED");
    } else {
        print_r($del->errorInfo());
    }
}

if($action=="dt"){ //delete theater
    $tno = $_GET["tno"];
    $cno = $_GET["cno"];

    $del = $db->prepare("Delete from theater where theaterNo=".$tno." and complexNo=".$cno);

    //print_r($del->queryString);

    if($del->execute()){
        //print("DELETED");
    } else {
        print_r($del->errorInfo());
    }
}

if($action=="dcomp"){ //delete complex
    $cno = $_GET["cno"];

    $del = $db->prepare("Delete from complex where complexNo=".$cno);

    //print_r($del->queryString);

    if($del->execute()){
        //print("DELETED");
    } else {
        print_r($del->errorInfo());
    }
}

if($action=="add"){ //add movie
    $title = clean_input($_POST['title']);
    $dir = clean_input($_POST['director']);
    $prod = clean_input($_POST['producer']);
    $plot = clean_input($_POST['plot']);
    $run = clean_input($_POST['runtime']);
    $rating = clean_input($_POST['rating']);
    $SDate = clean_input($_POST['sdate']);
    $EDate = clean_input($_POST['edate']);
    $supplier = clean_input($_POST['supplier']);
    $cast = clean_input($_POST['cast']);

    $insertString = "INSERT INTO `movie` (`Title`, `RunTime`, `Rating`, `Plot`, `Director`, `Producer`, `SDate`, `EDate`, `SupplierID`) VALUES ('".$title."', ".$run.", '".$rating."', '".$plot."', '".$dir."',' ".$prod."','".$SDate."', '".$EDate."', ".$supplier.")";

   //print($insertString);

    $ins = $db->prepare($insertString);

    if($ins->execute()){
       // print("ADDED");
    } else {
        print_r($ins->errorInfo());
    }

    $mid = $db->lastInsertId();
    
    $cast = explode("\n", $cast);
   // print_r($cast);
    foreach($cast as $actor){
        $actorInsStr = "INSERT INTO `actors` (`MovieID`, `fname`, `lname`) VALUES (".$mid.", ";
        $actor = clean_input($actor);
        list($fn, $ln) = explode(" ", $actor);
        $actorInsStr.="'".$fn."', '".$ln."')";
        $ains = $db->prepare($actorInsStr);
       // print_r($ains->queryString);
        $ains->execute();
    }


}

if($action=="addShow"){ //add a showing
    $movie=clean_input($_POST["title"]);
    $where=clean_input($_POST["where"]);
    $theater=clean_input($_POST["whereT"]);
    $STime=clean_input($_POST["stime"]);
    $Sdate=clean_input($_POST["sdate"]);

    $insString = "INSERT into showing (MovieID, ComplexNo, TheaterNo, STime, SDate, BookedSeats) values (".$movie.", ".$where.", ".$theater.", '".$STime."', '".$Sdate."', 0)";

    $ins = $db->prepare($insString);

    if($ins->execute()){
        // print("ADDED");
     } else {
         print_r($ins->errorInfo());
     }
 

} 

if($action=="addComplex"){ //add a complex
    $name=clean_input($_POST["name"]);
    $where=clean_input($_POST["address"]);
    $phone=clean_input($_POST["phone"]);

    $insString = "INSERT into complex (name, address, phone) values ('".$name."', '".$where."', ".$phone.")";

    $ins = $db->prepare($insString);

    if($ins->execute()){
        // print("ADDED");
     } else {
         print_r($ins->errorInfo());
     }

} 

if($action=="compAddress"){ //update complex address
    $cno=clean_input($_POST["cno"]);
    $addr=clean_input($_POST["address"]);

    $insString = "UPDATE complex set address='".$addr."' where ComplexNo=".$cno;

    $ins = $db->prepare($insString);

    if($ins->execute()){
        // print("ADDED");
     } else {
         print_r($ins->errorInfo());
     }

} 

if($action=="compName"){ //update complex name
    $cno=clean_input($_POST["cno"]);
    $name=clean_input($_POST["name"]);

    $insString = "UPDATE complex set name='".$name."' where ComplexNo=".$cno;

    $ins = $db->prepare($insString);

    if($ins->execute()){
        // print("ADDED");
     } else {
         print_r($ins->errorInfo());
     }

} 

if($action=="compPhone"){ //update complex phone
    $cno=clean_input($_POST["cno"]);
    $phone=clean_input($_POST["phone"]);

    $insString = "UPDATE complex set phone=".$phone." where ComplexNo=".$cno;

    $ins = $db->prepare($insString);

    if($ins->execute()){
        // print("ADDED");
     } else {
         print_r($ins->errorInfo());
     }

} 

if($action=="addTheater"){ //add a theater
    $cno=clean_input($_POST["complexNo"]);
    $tno=clean_input($_POST["tno"]);
    $size=clean_input($_POST["size"]);
    $screen=clean_input($_POST["screen"]);

    $insString = "INSERT into theater (TheaterNo, ComplexNo, Seats, Screen) values (".$tno.", ".$cno.", ".$size.", '".$screen."')";

    $ins = $db->prepare($insString);

    if($ins->execute()){
        // print("ADDED");
     } else {
         print_r($ins->errorInfo());
     }

} 

header("Location:".$_SERVER["HTTP_REFERER"]);
?>