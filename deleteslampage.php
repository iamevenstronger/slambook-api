<?php
 header('Access-Control-Allow-Origin: *');  
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['token']) || !isset($_GET['uid']) || !isset($_GET['slamname'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "keycontents" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();
}

$uid = filter_var($_GET['uid'],FILTER_SANITIZE_STRING);
$token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);
$slamname = filter_var($_GET['slamname'],FILTER_SANITIZE_STRING) ;

if(!isAuthenticated($token,$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "token" ;
    $resp["message"] = "Auth Error!" ;
    sendResponse($resp);
    die();
}

if(isNewSlam($uid,$slamname,$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "slamname" ;
    $resp["message"] = "Invalid slamname!" ;
    sendResponse($resp);
    die();
}
$sql = "UPDATE slampages SET deletedat=1 WHERE uid='$uid' AND slamname='$slamname'";

if ($conn->query($sql) === TRUE) {
    $resp["success"] = true ;
    $resp["message"] = "Slampage deleted successfully!" ;
    sendResponse($resp);
    die();
} else {
    $resp["success"] = false ;
    $resp["error_in"] = "Internal Error" ;
    $resp["message"] = "Error deleting record: " . $conn->error ;
    sendResponse($resp);
    die();
}

$conn->close();

?>