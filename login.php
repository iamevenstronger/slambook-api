<?php
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['username']) || !isset($_GET['password'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "username/passowrd" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();
}

$username = filter_var($_GET['username'],FILTER_SANITIZE_STRING);
$password = filter_var($_GET['password'],FILTER_SANITIZE_STRING);

if(!isLogin($username,$password,$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "username/passowrd" ;
    $resp["message"] = "Wrong Credentials!" ;
    sendResponse($resp);
    die();
}

$token_uuid = gen_uuid() ;
setcookie(
    "slam_token",
    $token_uuid,
    time() + (10 * 365 * 24 * 60 * 60)
);
setcookie(
    "slam_uid",
    getUidByUsername($username,$conn),
    time() + (10 * 365 * 24 * 60 * 60)
);
$sql = "UPDATE userdata SET token='$token_uuid' WHERE username='$username' and password='$password'";

if ($conn->query($sql) === TRUE) {
    $resp["success"] = true ;
    $resp["username"] = $username ;
    $resp["token"] = $token_uuid ;
    $resp["message"] = "Successfully Logged In!" ;
    sendResponse($resp);
} else {
    $resp["success"] = false ;
    $resp["error_in"] = "database" ;
    $resp["message"] = $conn->error ;
    sendResponse($resp);
    die();
}
$conn->close();
?>