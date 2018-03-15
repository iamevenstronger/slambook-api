<?php
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

function isNewUser($username_fn,$conn_fn){
    $sql = "SELECT * FROM userdata where username='$username_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
       return false;
    } else {
      return true;
    }
}

function isEmailExists($email_fn,$conn_fn){
    $sql = "SELECT * FROM userdata where email='$email_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
       return true;
    } else {
      return false;
    }
}

function sendResponse($reponse) {
    $reponse = json_encode($reponse);
    echo $reponse;
}

function isLogin($username_fn,$password_fn,$conn_fn) {
    $sql = "SELECT * FROM userdata where username='$username_fn' and password='$password_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
       return true;
    } else {
      return false;
    }
}

function isAuthenticated($token_fn,$conn_fn) {
    $sql = "SELECT * FROM userdata where token='$token_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
       return true;
    } else {
      return false;
    }   
}
?>