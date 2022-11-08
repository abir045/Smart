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





?>



<!doctype html>
<html lang="en">
<head>
    <?php include('comp/head.php'); ?>
    <title><?php echo $site_name; ?> - History</title>
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
                                    <h4 class="mb-sm-0 font-size-18">My Orders</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">My Orders</li>
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
                                                        <th>Price</th>
                                                        <th>Title</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 

                                                    $showorders = mysqli_query($conn, "SELECT * FROM cor_history WHERE `buyer` = '$id' ORDER BY id DESC");
                                            
                                                    while($row = mysqli_fetch_array($showorders)) { 

                                                        echo '            
                                                        <tr>
                                                        <td>'.$row['id'].'</td>
                                                        <td>'.$row['price'].'</td>
                                                        <td>'.$row['product_title'].'</td>
                                                        <td>'.$row['created_at'].'</td>
                                                        <td>
                                                        <a href="order.php?id='.$row['id'].'" class="btn btn-success btn-sm">View</a>
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