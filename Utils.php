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

function isSlamName($slamname_fn,$conn_fn) {
    $sql = "SELECT * FROM slampages where slamname='$slamname_fn' AND deletedat <> 1";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
       return true;
    } else {
      return false;
    }  
}

function getUidByUsername($username_fn,$conn_fn) {
    $sql = "SELECT uid FROM userdata WHERE username='$username_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
        $uid = null ;
        while($row = $result->fetch_assoc()) {
            $uid = $row["uid"] ;
        }
        return $uid;
    } else {
        return null;
    }
}

function getUsernameByUid($uid_fn,$conn_fn) {
    $sql = "SELECT username FROM userdata WHERE uid='$uid_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
        $username = null ;
        while($row = $result->fetch_assoc()) {
            $username = $row["username"] ;
        }
        return $username;
    } else {
        return null;
    }
}

function getContentByUid($uid_fn,$slamname_fn,$conn_fn) {
    $sql = "SELECT spid,content FROM slampages WHERE uid='$uid_fn' and slamname='$slamname_fn' AND deletedat <> 1";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
        $data = null ;
        while($row = $result->fetch_assoc()) {
            $data = $row ;
        }
        return $data;
    } else {
        return null;
    }
}

function isNewSlam($uid_fn,$slamname_fn,$conn_fn) {
    $sql = "SELECT spid FROM slampages WHERE uid='$uid_fn' and slamname='$slamname_fn' AND deletedat <> 1";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
        return false;
    }
    return true;
}

function isInvalidString($str){
    return !preg_match('/^[a-zA-Z_]+$/',$str);
}
?>