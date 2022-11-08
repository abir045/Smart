<?php

require_once('server/db.php');

$payload = file_get_contents('php://input');

$sql = "SELECT coinbase_secret FROM `site_settings` WHERE `id`='1';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$secret = $row["coinbase_secret"];


$headerName = 'x-cc-webhook-signature';

$headers = getallheaders();
$signraturHeader = isset($headers[$headerName]) ? $headers[$headerName] : null;


//SHA256 HMAC of payload with secret
$signature = hash_hmac('sha256', $payload, $secret);

if (hash_equals($signature, $signraturHeader)) {




    $jsonString = json_decode($payload, true);
    
    $id = $jsonString['event']['data']['id'];
    $event_type = $jsonString['event']['type'];


    if($event_type != 'charge:created'){
        $fname = time().'_'.$id;
        $myfile = fopen('../coinbaseLogs/'.$fname.".txt", "w");
        fwrite($myfile, print_r($payload, true));
        fclose($myfile);
    }

    $sql = "UPDATE `billing` SET `status`='$event_type' WHERE `uqid`='$id';";
    $result = mysqli_query($conn, $sql);

    if($event_type == 'charge:confirmed'){
        $result = mysqli_query($conn, "SELECT * FROM `billing` WHERE `uqid` = '$id';");
        $row = mysqli_fetch_array($result);

        $userid = $row['user_id'];
        $amount = $row['amount'];
        $paid = $row['paid'];
        if($paid == 0){

            $sql = "UPDATE `users` SET `balance`=`balance`+'$amount' WHERE `id`='$userid';";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE `billing` SET `paid`='1' WHERE `uqid`='$id';";
        }

        

    }


}  