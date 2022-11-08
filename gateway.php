<?php

session_start();
require_once('server/db.php');
include('comp/functions.php');

if (!isset($_SESSION["loggedin"])){
    header('Location: login.php');
}

$id = $_SESSION["id"];
$username = $_SESSION["username"];

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $sql = "SELECT coinbase_api FROM `site_settings` WHERE `id`='1';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $coinbase_api = $row["coinbase_api"];

    $amount = mysqli_real_escape_string($conn,$_POST['amount']);


    if($amount < 5 || $amount > 200){
        $error = "Invalid amount";
        $error = urlencode($error);
        header("Location: deposit.php?error=".$error);
        exit();
    }

    $post = array(
        "name" => "Balance Deposit",
        "description" => "Deposit ".$amount." USD to ".ucfirst($username),
        "local_price" => array(
            'amount' => $amount,
            'currency' => 'USD'
        ),
        "pricing_type" => "fixed_price",
        "metadata" => array(
            'name' => $username
        )
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.commerce.coinbase.com/charges');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
    
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'X-Cc-Api-Key: '.$coinbase_api;
    $headers[] = 'X-Cc-Version: 2018-03-22';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);
    $uqid = $response['data']['id'];
    $url = $response['data']['hosted_url'];


    
    $sql = "INSERT INTO `billing` (`amount`, `status`, `uqid`, `url`, `user_id`) VALUES ('$amount', 'pending', '$uqid', '$url', '$id');";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("Location: ".$url);
        exit();
    }



}

?>