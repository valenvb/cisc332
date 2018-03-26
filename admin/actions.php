<?php
include_once '../lib/database.php';
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

header("Location:".$_SERVER["HTTP_REFERER"]);
?>