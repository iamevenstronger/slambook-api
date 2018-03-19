<?php
 header('Access-Control-Allow-Origin: *');  
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['spid'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "spid" ;
    $resp["message"] = "spid needed!" ;
    sendResponse($resp);
    die();
}

$spid = filter_var($_GET['spid'],FILTER_SANITIZE_STRING);

$sql = "SELECT content FROM slampages WHERE spid='$spid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $slamcustomfields = null;
    $slamname = null ;
    $slamdescription = null ;
    while($row = $result->fetch_assoc()) {
        $slamcustomfields = json_decode($row["content"]);
        $slamname = $row["slamname"] ;
        $slamdescription = $row["slamdescription"] ;
    }
    $resp["success"] = true ;
    $resp["slamname"] = $slamname ;
    $resp["slamdescription"] = $slamdescription ;
    $resp["data"] = $slamcustomfields ;
    sendResponse($resp);  
} else {
    $resp["success"] = false ;
    $resp["message"] = "Invalid spid!" ;
    sendResponse($resp); 
}
$conn->close();
?>