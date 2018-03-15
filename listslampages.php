<?php
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['token']) || !isset($_GET['uid'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "token/uid" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();
}

$token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);
$uid = filter_var($_GET['uid'],FILTER_SANITIZE_STRING);

if(!isAuthenticated($token,$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "token" ;
    $resp["message"] = "Auth Error!" ;
    sendResponse($resp);
    die();
}

$sql = "SELECT * FROM slampages WHERE uid='$uid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $slampages = array();
    while($row = $result->fetch_assoc()) {
        $row["content"] = json_decode($row["content"]);
        array_push($slampages,$row);
    }
    $resp["success"] = true ;
    $resp["data"] = $slampages ;
    sendResponse($resp);  
} else {
    $resp["success"] = true ;
    $resp["data"] = array() ;
    sendResponse($resp); 
}
$conn->close();
?>