<?php
require 'Utils.php';

if (isset($_COOKIE['slam_token'])) {
    unset($_COOKIE['slam_token']);
    setcookie('slam_token', null, -1, '/');
    $resp["success"] = true ;
    $resp["message"] = "You are Logged Out!" ;
    sendResponse($resp)
} else {
    $resp["success"] = true ;
    $resp["message"] = "You are Already Logged Out!" ;
    sendResponse($resp)
}
?>