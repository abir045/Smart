<?php

session_start();
require_once('server/db.php');
include('comp/functions.php');

if (!isset($_SESSION["loggedin"])){
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id'];
$username = $_SESSION['username'];

if ( !(intval(getUserData($conn, $id, "role")) == 1 || intval(getUserData($conn, $id, "role")) == 2) ){
    header('Location: login.php');
    exit();
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $amount = intval(mysqli_real_escape_string($conn, $_POST['amount']));
    $wallet = mysqli_real_escape_string($conn, $_POST['wallet']);
    $coin = mysqli_real_escape_string($conn, $_POST['coin']);

    $coins = array('BTC','LTC','ETH','USDT(ERC-20)','USDT(TRC-20)');

    if(!in_array($coin, $coins)){
        exitWithError("Invalid coin");
    }

    if($amount < 5 || $amount > 200){
        exitWithError("Invalid amount");
    }

    //if user has the amount in the wallet, then we can proceed
    $userBal = getUserData($conn, $id, "bal");
    if($userBal < $amount){
        exitWithError("You don't have enough balance");
    }

    $sql = "UPDATE `users` SET `bal`=`bal`-".$amount." WHERE `id`='".$id."';";
    mysqli_query($conn, $sql);


    $sql = "INSERT INTO `payouts` (`seller`, `amount`, `wallet`, `coin`, `status`) VALUES ('$id', '$amount', '$wallet', '$coin', '0');";
    mysqli_query($conn, $sql);

    exitWithSuccess("Payout request sent");

}


?>



<!doctype html>
<html lang="en">
<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - Payout Requests</title>
</head>

    <body data-topbar="dark" data-layout-mode="dark" data-sidebar="dark">
        <div id="layout-wrapper">
        <?php include 'comp/nav.php'; ?>
           
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Request Payout</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Seller</a></li>
                                            <li class="breadcrumb-item active">Request Payout</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
          
                            if(isset($_GET['error'])){
                                $error = urldecode($_GET['error']);
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> '.$error.'
                                </div>';

                            }elseif(isset($_GET['success'])){
                                $success = urldecode($_GET['success']);
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> '.$success.'
                                </div>';
                            }


                            ?>

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                <div class="card-body">
                                    <form class="row g-3" method="post">
                                        <div class="col-md-6">
                                            <label for="select" class="form-label ">Currency</label>
                                            <select class="form-select" name="coin" required="" id="select">
                                            <option selected="" disabled="" value="">Choose currency</option>
                                            <option value="BTC">BTC</option>
                                            <option value="LTC">LTC</option>
                                            <option value="ETH">ETH</option>
                                            <option value="USDT(ERC-20)">USDT (ERC-20)</option>
                                            <option value="USDT(TRC-20)">USDT (TRC-20)</option>
                                            </select>
                                        </div>
                                        

                                        <div class="col-md-6">
                                            <label for="cr" class="form-label">Amount</label>
                                            <div class="input-group has-validation">
                                            <input type="text" class="form-control" name="amount" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="cr" class="form-label">Wallet Address</label>
                                            <div class="input-group has-validation">
                                            <input type="text" class="form-control" name="wallet" required="">
                                            </div>
                                        </div>
                                        <div class="col-12" style="display: flex;justify-content: space-between;">
                                            <button type="submit" class="btn btn-primary">Submit Request</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                                <div class="bio layout-spacing ">
                                    <div class="widget-content widget-content-area">
                                        <h5 class="">Payouts</h3>


                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Coin</th>
                                                        <th>Wallet</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 

                                                    $showorders = mysqli_query($conn, "SELECT * FROM payouts WHERE seller = '$id' ORDER BY status,id DESC");
                                            
                                                    while($row = mysqli_fetch_array($showorders)) { 
                                                        if($row['status'] == '0'){
                                                            $status = '<span class="badge bg-warning">Pending</span>';
                                                        }else{
                                                            $status = '<span class="badge bg-success">Completed</span>';
                                                        }

                                                        echo '            
                                                        <tr>
                                                        <td>'.$row['id'].'</td>
                                                        <td>'.$row['amount'].'</td>
                                                        <td>'.$status.'</td>
                                                        <td>'.$row['coin'].'</td>
                                                        <td>'.$row['wallet'].'</td>
                                                        <td>'.$row['created_at'].'</td>
                                                        </tr>';

                                                    }

                                                    ?>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        
                    </div>
                </div>
                <?php include 'comp/footer.php'; ?>
            </div>
        </div>
        
        <div class="rightbar-overlay"></div>
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>