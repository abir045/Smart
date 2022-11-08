<?php

function randString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getUserData($conn, $id, $type){
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user[$type];
}

function getCatName($conn, $id){
    $sql = "SELECT * FROM cor_cat WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $cat = mysqli_fetch_assoc($result);
    return $cat['title'];
}

function exitWithError($error) {
    //get current url
    $currentUrl = basename($_SERVER['PHP_SELF']);
    //redirect to same url with error message
    $error = urlencode($error);
    header("location: " . $currentUrl . "?error=" . $error);
    exit();
}

function exitWithSuccess($success) {
    //get current url
    $currentUrl = basename($_SERVER['PHP_SELF']);
    //redirect to same url with error message
    $success = urlencode($success);
    header("location: " . $currentUrl . "?success=" . $success);
    exit();
}


?>