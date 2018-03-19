<?php
 header('Access-Control-Allow-Origin: *');  
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['username']) || !isset($_GET['slamname'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "username/slamname" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();
}

if(isNewUser(filter_var($_GET['username'],FILTER_SANITIZE_STRING),$conn) || !isSlamName(filter_var($_GET['slamname'],FILTER_SANITIZE_STRING),$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "username/slamname" ;
    $resp["message"] = "username/slamname not exists!" ;
    sendResponse($resp);
    die();
}

$content = json_decode($_GET['content']);
$username = filter_var($_GET['username'],FILTER_SANITIZE_STRING) ;
$slamname = filter_var($_GET['slamname'],FILTER_SANITIZE_STRING) ;
$uid  = getUidByUsername($username,$conn);
$data = getContentByUid($uid,$slamname,$conn);
$spid = $data["spid"] ;
if(!isKeysValid($content,$data["content"])) {
    $resp["success"] = false ;
    $resp["error_in"] = "keys" ;
    $resp["message"] = "key may not exists!" ;
    sendResponse($resp);
    die();
}

$swid = gen_uuid() ;
$content = $_GET['content'] ;
if(isset($_COOKIE['slam_uid'])) {
    $uid = $_COOKIE['uid'] ;
    $sql = "INSERT INTO slamwrites (swid,spid,uid,content) VALUES ('$swid','$spid', '$uid', '$content')";
} else {
    $uid = "Anonymous" ;
    $sql = "INSERT INTO slamwrites (swid,spid,content) VALUES ('$swid','$spid', '$content')";
}
if ($conn->query($sql) === TRUE) {
    $resp["success"] = true ;
    $resp["swid"] = $swid ;
    $resp["spid"] = $spid ;
    $resp["uid"] = $uid ;
    $resp["message"] = "Slamwrite Done!" ;
    sendResponse($resp);
} else {
    $resp["success"] = false ;
    $resp["error_in"] = "database" ;
    $resp["message"] = "Error: " . $sql . "<br>" . $conn->error ;
    sendResponse($resp);
    die();
}
$conn->close();


function isKeysValid($content_fn,$custom_string) {
    $key_arr = array("nickname","first meet","first fight","Tell me about something","link dedicated to me","your location","customfields");
    for($i = 0 ; $i < 7 ; $i++) {
        if(!array_key_exists($key_arr[$i],$content_fn)) {
            return false;
        }
    }
    $cus_arr = json_decode($custom_string);
    $cus_arr = $cus_arr->{'customfields'} ;
    for($i = 0 ; $i < count($cus_arr) ; $i++) {
        if(!array_key_exists($cus_arr[$i],$content_fn->{'customfields'})) {
            return false;
        }    
    }
    return true;
}
?>