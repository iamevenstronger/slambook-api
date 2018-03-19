<?php
 header('Access-Control-Allow-Origin: *');  
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['slamname'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "slamname" ;
    $resp["message"] = "slamname needed!" ;
    sendResponse($resp);
    die();
}

$slamname = filter_var($_GET['slamname'],FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM slampages WHERE slamname='$slamname'";
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
    $resp["message"] = "Invalid slamname!" ;
    sendResponse($resp); 
}
$conn->close();
?>