<?php
 header('Access-Control-Allow-Origin: *');  
require 'connection.php';
require 'Utils.php';

if(!isset($_GET['token']) || !isset($_GET['uid']) || !isset($_GET['content']) || !isset($_GET['slamname']) || !isset($_GET['slamdescription'])) {
    $resp["success"] = false ;
    $resp["error_in"] = "keycontents" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();
}

if(!$_GET['slamname'] || !$_GET['slamdescription']) {
    $resp["success"] = false ;
    $resp["error_in"] = "keycontents" ;
    $resp["message"] = "Enter All Credentials!" ;
    sendResponse($resp);
    die();  
}
$content = json_decode($_GET['content']);
$uid = filter_var($_GET['uid'],FILTER_SANITIZE_STRING);
$token = filter_var($_GET['token'],FILTER_SANITIZE_STRING);
$slamdescription = stripScript($_GET['slamdescription']) ;
$slamname = filter_var($_GET['slamname'],FILTER_SANITIZE_STRING) ;

if(!isAuthenticated($token,$conn)) {
    $resp["success"] = false ;
    $resp["error_in"] = "token" ;
    $resp["message"] = "Auth Error!" ;
    sendResponse($resp);
    die();
}

if(!isLimitCustom($content->customfields)) {
    $resp["success"] = false ;
    $resp["error_in"] = "customfields" ;
    $resp["message"] = "Custom fields exceeded!" ;
    sendResponse($resp);
    die();   
}

if(!array_key_exists("customfields",$content)) {
    $resp["success"] = false ;
    $resp["error_in"] = "key" ;
    $resp["message"] = "Invalid Error!" ;
    sendResponse($resp);
    die();   
}

$spid = gen_uuid() ;
$content = $_GET['content'] ;
$sql = "INSERT INTO slampages (uid,spid,slamname,slamdescription,content) VALUES ('$uid','$spid', '$slamname', '$slamdescription', '$content')";
if ($conn->query($sql) === TRUE) {
    $resp["success"] = true ;
    $resp["spid"] = $spid ;
    $resp["slamname"] = $slamname ;
    $resp["slamdescription"] = $slamdescription ;
    $resp["content"] = json_decode($content) ;
    $resp["uid"] = $uid ;
    $resp["message"] = "Slampage Successfuly Created!" ;
    sendResponse($resp);
} else {
    $resp["success"] = false ;
    $resp["error_in"] = "database" ;
    $resp["message"] = "Error: " . $sql . "<br>" . $conn->error ;
    sendResponse($resp);
    die();
}
$conn->close();

function isLimitCustom($customfields_fn) {
    return (count($customfields_fn)<=20)?true:false;
}

function stripScript($html) {
$doc = new DOMDocument();
$doc->loadHTML($html);
$script_tags = $doc->getElementsByTagName('script');
$length = $script_tags->length;
for ($i = 0; $i < $length; $i++) {
  $script_tags->item($i)->parentNode->removeChild($script_tags->item($i));
}
 return $doc->saveHTML();
}
?>