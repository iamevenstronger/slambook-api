<?php
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['token']) || !isset($_GET['spid'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "token/spid" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();
}

$token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);
$spid = filter_var($_GET['spid'],FILTER_SANITIZE_STRING);

if(!isAuthenticated($token,$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "token" ;
    $resp["message"] = "Auth Error!" ;
    sendResponse($resp);
    die();
}

$sql = "SELECT uid, swid, content FROM slamwrites WHERE spid='$spid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $slamwrites = array();
    while($row = $result->fetch_assoc()) {
        $row["content"] = json_decode($row["content"]);
        array_push($slamwrites,$row);
    }
    $resp["success"] = true ;
    $resp["data"] = $slamwrites ;
    sendResponse($resp);  
} else {
    $resp["success"] = true ;
    $resp["data"] = array() ;
    sendResponse($resp); 
}
$conn->close();

?>