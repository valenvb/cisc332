<?php
include_once '../lib/database.php';
if(!isset($_GET["action"])){
    print("NO ACTION");
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

$action = $_GET['action'];
print($action);

if($action=="dr"){ //delete reservation
    $s_time = $_GET["s_time"];
    $s_day = $_GET["s_day"];
    $m_id = $_GET["movie_id"];
    $u_id = $_GET["uid"];
    $del = $db->prepare("DELETE FROM RESERVATION WHERE userID=".$u_id." AND STIME = '".$s_time."' AND SDATE = '".$s_day."' AND MOVIEID = ".$m_id);
    echo("DELETE FROM RESERVATION WHERE userID=".$u_id." AND STIME = '".$s_time."' AND SDATE = '".$s_day."' AND MOVIEID = ".$m_id);
    if($del->execute()){
        //print("DELETED");
    } else {
        print_r($del->errorInfo());
    }
}
header("Location:".$_SERVER["HTTP_REFERER"]);
?>