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

header("Location:".$_SERVER["HTTP_REFERER"]);
?>