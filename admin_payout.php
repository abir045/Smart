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

if (intval(getUserData($conn, $id, "role")) != 1){
    header('Location: login.php');
    exit();
}


if(isset($_GET['approve'])){
    $id = mysqli_real_escape_string($conn, $_GET['approve']);

    $sql = "UPDATE `payouts` SET `status`='1' WHERE `id`='$id';";
    $result = mysqli_query($conn, $sql);


    exitWithSuccess("Payout approved");

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
                                    <h4 class="mb-sm-0 font-size-18">Payout Requests</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                            <li class="breadcrumb-item active">Payout Requests</li>
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

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                                <div class="bio layout-spacing ">
                                    <div class="widget-content widget-content-area">


                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Coin</th>
                                                        <th>Wallet</th>
                                                        <th>User</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 

                                                    $showorders = mysqli_query($conn, "SELECT * FROM payouts ORDER BY status,id DESC");
                                            
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
                                                        <td>'.getUserData($conn, $row['seller'], "username").'</td>
                                                        <td>'.$row['created_at'].'</td>
                                                        <td>';
                                                        if($row['status'] == '0'){
                                                            echo '
                                                            <a href="admin_payout.php?approve='.$row['id'].'" class="btn btn-success btn-sm">Paid</a>';
                                                        }
                                                        echo '
                                                        </td>
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