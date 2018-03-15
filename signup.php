<?php
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['username']) || strlen(filter_var($_GET['username'],FILTER_SANITIZE_STRING))<4 || strlen(filter_var($_GET['username'],FILTER_SANITIZE_STRING))>32 || !isNewUser(filter_var($_GET['username'],FILTER_SANITIZE_STRING),$conn)){
    $resp["success"] = false ;
    $resp["error_in"] = "username" ;
    $resp["message"] = "Not a valid username!" ;
    sendResponse($resp);
    die();
}
if(!isset($_GET['password']) || strlen(filter_var($_GET['password'],FILTER_SANITIZE_STRING))<4 || strlen(filter_var($_GET['password'],FILTER_SANITIZE_STRING))>32) {
    $resp["success"] = false ;
    $resp["error_in"] = "password" ;
    $resp["message"] = "Enter valid password!" ;
    sendResponse($resp);
    die();
}

if(isEmailExists(filter_var($_GET['email'],FILTER_SANITIZE_EMAIL),$conn) || !isset($_GET['email'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "email" ;
    $resp["message"] = "Enter valid email!" ;
    sendResponse($resp);
    die();
}

$username = filter_var($_GET['username'],FILTER_SANITIZE_STRING);
$email = filter_var($_GET['email'],FILTER_SANITIZE_EMAIL);
$password = filter_var($_GET['password'],FILTER_SANITIZE_STRING);

$token_uuid = gen_uuid() ;
$uid = gen_uuid() ;
$sql = "INSERT INTO userdata (uid,username,password,email,token,status) VALUES ('$uid','$username', '$password', '$email', '$token_uuid','')";
if ($conn->query($sql) === TRUE) {
    setcookie(
        "slam_token",
        $token_uuid,
        time() + (10 * 365 * 24 * 60 * 60)
    );
    $resp["success"] = true ;
    $resp["uid"] = $uid ;
    $resp["username"] = $username ;
    $resp["token"] = $token_uuid ;
    $resp["message"] = "Registration Done!" ;
    sendResponse($resp);
} else {
    $resp["success"] = false ;
    $resp["error_in"] = "database" ;
    $resp["message"] = "Error: " . $sql . "<br>" . $conn->error ;
    sendResponse($resp);
    die();
}
$conn->close();
?>